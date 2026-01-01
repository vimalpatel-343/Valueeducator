<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ModelPortfolioStockModel;
use App\Models\StockUpdateModel;
use App\Models\QuarterlyUpdateModel;
use App\Models\ManagementInterviewModel;
use App\Models\SubstackUpdateModel;
use App\Models\YoutubeVideoModel;
use App\Models\SiteSettingsModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $productModel;
    protected $modelPortfolioStockModel;
    protected $stockUpdateModel;
    protected $quarterlyUpdateModel;
    protected $managementInterviewModel;
    protected $substackUpdateModel;
    protected $youtubeVideoModel;
    protected $siteSettingsModel;
    protected $userModel;
    
    public function __construct()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        helper('common');
        
        $this->productModel = new ProductModel();
        $this->modelPortfolioStockModel = new ModelPortfolioStockModel();
        $this->stockUpdateModel = new StockUpdateModel();
        $this->quarterlyUpdateModel = new QuarterlyUpdateModel();
        $this->managementInterviewModel = new ManagementInterviewModel();
        $this->substackUpdateModel = new SubstackUpdateModel();
        $this->youtubeVideoModel = new YoutubeVideoModel();
        $this->siteSettingsModel = new SiteSettingsModel();
        $this->userModel = new UserModel();
    }
    
    // Modified function to check both subscription and KYC status
    private function checkAccess($productId)
    {
        if (!session()->get('isLoggedIn')) {
            return [
                'hasAccess' => false,
                'reason' => 'not_logged_in',
                'showKycModal' => false,
                'showSubscriptionExpiredModal' => false,
                'expiredProducts' => []
            ];
        }

        $userId = session()->get('userId');
        $userSubscriptionModel = new \App\Models\UserSubscriptionModel();
        
        // Check subscription status for the requested product
        $hasActiveSubscription = $userSubscriptionModel->hasActiveSubscription($userId, $productId);
        
        // Check for expired subscriptions for both products
        $db = \Config\Database::connect();
        $expiredSubscriptions = $db->table('user_subscriptions')
            ->where('user_id', $userId)
            ->where('end_date <', date('Y-m-d'))
            ->get()
            ->getResultArray();
        
        $expiredProducts = [];
        foreach ($expiredSubscriptions as $sub) {
            $expiredProducts[] = $sub['product_id'];
        }
        
        // If no active subscription for requested product
        if (!$hasActiveSubscription) {
            // Check if user has an expired subscription for this specific product
            $showExpiredModal = in_array($productId, $expiredProducts);
            
            return [
                'hasAccess' => false,
                'reason' => 'subscription',
                'showKycModal' => false,
                'showSubscriptionExpiredModal' => $showExpiredModal,
                'expiredProducts' => $expiredProducts
            ];
        }
        
        // Check KYC status
        $user = $this->userModel->find($userId);
        $hasKyc = false;
        
        if ($user) {
            $currentDate = date('Y-m-d');
            // Check if KYC is completed and still valid
            if ($user['fld_kyc_status'] == 1 && 
                $user['fld_kyc_start_date'] <= $currentDate && 
                $user['fld_kyc_end_date'] >= $currentDate) {
                $hasKyc = true;
            }
        }
        
        return [
            'hasAccess' => $hasKyc,
            'reason' => $hasKyc ? 'none' : 'kyc',
            'showKycModal' => !$hasKyc,
            'showSubscriptionExpiredModal' => false,
            'expiredProducts' => $expiredProducts
        ];
    }

    public function emergingTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Emerging Titans
        $product = $this->productModel->where('fld_slug', 'emerging-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];

        // Get product pricing
        $productPricing = $product['fld_pricing'] ?? 0;

        // Fetch Latest Recommendations (Top 7)
        $latestRecommendations = $this->modelPortfolioStockModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_date_of_recommendation', 'DESC')
            ->findAll(7);
        
        // Fetch Stock Updates (Latest 3) with stock names
        $db = \Config\Database::connect();
        $stockUpdates = $db->table('ve_stock_updates su')
            ->select('su.*, s.fld_stock_name')
            ->join('ve_stocks s', 'su.fld_stock_id = s.id', 'left')
            ->where('su.fld_product_id', $productId)
            ->where('su.fld_status', 1)
            ->orderBy('su.fld_update_date', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();
        
        $totalCount = $db->table('ve_stock_updates su')
            ->where('su.fld_product_id', $productId)
            ->where('su.fld_status', 1)
            ->countAllResults();

        // Fetch Quarterly Model Portfolio Updates (Latest 1)
        $quarterlyUpdates = $this->quarterlyUpdateModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll(1);
        
        // Fetch Management Interviews (Latest 1)
        $managementInterviews = $this->managementInterviewModel
            ->where('fld_product_id', $productId)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll(1);
        
        // Fetch Latest Substack Updates (Latest 3)
        $substackUpdates = $this->substackUpdateModel
            ->where('fld_product_ids', 1)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll(3);

        // Fetch YouTube Videos (Latest 1)
        $youtubeVideos = $this->youtubeVideoModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_posted_at', 'DESC')
            ->findAll(1);
        
        // Pre-process YouTube videos to add formatted data
        foreach ($youtubeVideos as &$video) {
            // The video ID is already stored in fld_video_id
            $video['video_id'] = $video['fld_video_id'];
            // Format the time elapsed
            $video['time_elapsed'] = $this->timeElapsedString(strtotime($video['fld_posted_at']));
            // Format the view count
            $video['formatted_views'] = number_format($video['fld_total_views']);
        }
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();

        // Get all products for comparison section
        $allProducts = $this->productModel->getAllActiveProducts();

        $dashboardScuttlebuttModel = new \App\Models\DashboardScuttlebuttModel();
        $dashboardScuttlebutt = $dashboardScuttlebuttModel->getByProductId($productId);

        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'emerging-titans',
            'productPricing' => $productPricing,
            'latestRecommendations' => $latestRecommendations,
            'stockUpdates' => $stockUpdates,
            'total_count' => $totalCount,
            'quarterlyUpdates' => $quarterlyUpdates,
            'managementInterviews' => $managementInterviews,
            'substackUpdates' => $substackUpdates,
            'youtubeVideos' => $youtubeVideos,
            'allProducts' => $allProducts,
            'dashboardScuttlebutt' => $dashboardScuttlebutt,
            'meta' => [
                'title' => 'Emerging Titans Dashboard - Value Educator',
                'description' => 'Access your Emerging Titans dashboard with latest recommendations, stock updates, and more.'
            ]
        ];
        
        return view('front/dashboard_emerging_titan', $data);
    }
    
    // Placeholder for subscription checking
    private function checkSubscriptionAccess($productId)
    {
        if (!session()->get('isLoggedIn')) {
            return false;
        }

        $userId = session()->get('userId');
        $userSubscriptionModel = new \App\Models\UserSubscriptionModel();
        
        return $userSubscriptionModel->hasActiveSubscription($userId, $productId);
    }

    private function getProductPricing($productId)
    {
        $productModel = new \App\Models\ProductModel();
        $product = $productModel->find($productId);
        
        return $product ? $product['fld_pricing'] : 0;
    }
    
    // Helper function to extract YouTube video ID
    protected function getYouTubeVideoId($url)
    {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $url, $matches);
        return $matches[1] ?? null;
    }
    
    // Helper function to format time elapsed
    protected function timeElapsedString($datetime, $full = false)
    {
        $now = new \DateTime;
        $ago = new \DateTime('@' . $datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function tinyTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Tiny Titans
        $product = $this->productModel->where('fld_slug', 'tiny-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];
        
        // Get product pricing
        $productPricing = $product['fld_pricing'] ?? 0;

        // Fetch Latest Recommendations (Top 7)
        $latestRecommendations = $this->modelPortfolioStockModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_date_of_recommendation', 'DESC')
            ->findAll(7);
        
        // Fetch Stock Updates (Latest 3) with stock names
        $db = \Config\Database::connect();
        $stockUpdates = $db->table('ve_stock_updates su')
            ->select('su.*, s.fld_stock_name')
            ->join('ve_stocks s', 'su.fld_stock_id = s.id', 'left')
            ->where('su.fld_product_id', $productId)
            ->where('su.fld_status', 1)
            ->orderBy('su.fld_update_date', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();
        
        $totalCount = $db->table('ve_stock_updates su')
            ->where('su.fld_product_id', $productId)
            ->where('su.fld_status', 1)
            ->countAllResults();

        // Fetch Quarterly Model Portfolio Updates (Latest 1)
        $quarterlyUpdates = $this->quarterlyUpdateModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll(1);
        
        // Fetch Management Interviews (Latest 1)
        $managementInterviews = $this->managementInterviewModel
            ->where('fld_product_id', $productId)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll(1);
        
        // Fetch Latest Substack Updates (Latest 3)
        $substackUpdates = $this->substackUpdateModel
            ->where('fld_product_ids', 1)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll(3);
        
        // Fetch YouTube Videos (Latest 1)
        $youtubeVideos = $this->youtubeVideoModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_posted_at', 'DESC')
            ->findAll(1);
        
        // Pre-process YouTube videos to add formatted data
        foreach ($youtubeVideos as &$video) {
            // The video ID is already stored in fld_video_id
            $video['video_id'] = $video['fld_video_id'];
            // Format the time elapsed
            $video['time_elapsed'] = $this->timeElapsedString(strtotime($video['fld_posted_at']));
            // Format the view count
            $video['formatted_views'] = number_format($video['fld_total_views']);
        }
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for comparison section
        $allProducts = $this->productModel->getAllActiveProducts();

        $dashboardScuttlebuttModel = new \App\Models\DashboardScuttlebuttModel();
        $dashboardScuttlebutt = $dashboardScuttlebuttModel->getByProductId($productId);

        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'tiny-titans',
            'productPricing' => $productPricing,
            'latestRecommendations' => $latestRecommendations,
            'stockUpdates' => $stockUpdates,
            'total_count' => $totalCount,
            'quarterlyUpdates' => $quarterlyUpdates,
            'managementInterviews' => $managementInterviews,
            'substackUpdates' => $substackUpdates,
            'youtubeVideos' => $youtubeVideos,
            'allProducts' => $allProducts,
            'dashboardScuttlebutt' => $dashboardScuttlebutt,
            'meta' => [
                'title' => 'Tiny Titans Dashboard - Value Educator',
                'description' => 'Access your Tiny Titans dashboard with latest recommendations, stock updates, and more.'
            ]
        ];
        
        return view('front/dashboard_tiny_titan', $data);
    }

    public function portfolioEmergingTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Emerging Titans
        $product = $this->productModel->where('fld_slug', 'emerging-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];
        
        // Get product pricing
        $productPricing = $product['fld_pricing'] ?? 0;

        // Fetch portfolio data
        $db = \Config\Database::connect();
        
        // Get portfolio overview from ve_portfolio_overviews table
        $portfolioOverview = $db->table('ve_portfolio_overviews')
            ->where('fld_product_id', $productId)
            ->get()
            ->getRowArray();
        
        // Get portfolio distribution from ve_portfolio_distributions table
        $portfolioDistribution = $db->table('ve_portfolio_distributions')
            ->where('fld_product_id', $productId)
            ->get()
            ->getResultArray();
        
        // Get quarterly updates from ve_quarterly_updates table
        $quarterlyUpdates = $db->table('ve_quarterly_updates')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->get(3) // Limit to 3 records
            ->getResultArray();
        
        // Get latest recommendations (Top 7) from ve_stocks table
        $latestRecommendations = $db->table('ve_stocks')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_date_of_recommendation', 'DESC')
            ->get(7) // Limit to 7 records
            ->getResultArray();
        
        // Get model portfolio from ve_stocks table
        $modelPortfolio = $db->table('ve_stocks')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_date_of_recommendation', 'DESC')
            ->get()
            ->getResultArray();
        
        // Calculate returns for each stock in model portfolio
        foreach ($modelPortfolio as &$stock) {
            // Calculate return percentage
            if ($stock['fld_price_at_recommendation'] > 0) {
                $return = $stock['fld_returns'];
                $stock['return'] = number_format($return, 2);
                $stock['return_class'] = $return >= 0 ? 'green' : 'red';
            } else {
                $stock['return'] = '0.00';
                $stock['return_class'] = 'green';
            }
        }
        
        // Get rebalance timeline from ve_rebalance_timelines table
        $rebalanceTimeline = $db->table('ve_rebalance_timelines')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_updated_at', 'DESC')
            ->get()
            ->getResultArray();
        
        // Process rebalance timeline to extract items from JSON fields
        foreach ($rebalanceTimeline as &$timeline) {
            // Initialize counts
            $timeline['buy_count'] = 0;
            $timeline['sell_count'] = 0;
            $timeline['items'] = [];
            
            // Check if there are JSON fields containing rebalance items
            // Based on the database structure, we might need to look for fields like:
            // fld_buy_items, fld_sell_items, or similar
            // Since we don't have the exact field names, we'll skip this for now
            
            // If there are fields containing JSON data with items, we would decode them here
            // For example:
            // if (!empty($timeline['fld_buy_items'])) {
            //     $buyItems = json_decode($timeline['fld_buy_items'], true);
            //     $timeline['buy_count'] = count($buyItems);
            //     $timeline['items'] = array_merge($timeline['items'], $buyItems);
            // }
            // if (!empty($timeline['fld_sell_items'])) {
            //     $sellItems = json_decode($timeline['fld_sell_items'], true);
            //     $timeline['sell_count'] = count($sellItems);
            //     $timeline['items'] = array_merge($timeline['items'], $sellItems);
            // }
        }
        
        // Get stock updates
        $stockUpdates = $db->table('ve_stock_updates su')
            ->select('su.*, s.fld_stock_name')
            ->join('ve_stocks s', 'su.fld_stock_id = s.id', 'left')
            ->where('su.fld_product_id', $productId)
            ->where('su.fld_status', 1)
            ->orderBy('su.fld_update_date', 'DESC')
            ->get()
            ->getResultArray();
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'emerging-titans',
            'productPricing' => $productPricing,
            'portfolioOverview' => $portfolioOverview,
            'portfolioDistribution' => $portfolioDistribution,
            'quarterlyUpdates' => $quarterlyUpdates,
            'latestRecommendations' => $latestRecommendations,
            'modelPortfolio' => $modelPortfolio,
            'rebalanceTimeline' => $rebalanceTimeline,
            'stockUpdates' => $stockUpdates,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Emerging Titans Portfolio - Value Educator',
                'description' => 'View your Emerging Titans portfolio with current holdings, performance, and rebalance history.'
            ]
        ];
        
        return view('front/portfolio_emerging_titan', $data);
    }

    public function portfolioTinyTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Tiny Titans
        $product = $this->productModel->where('fld_slug', 'tiny-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];
        
        // Get product pricing
        $productPricing = $product['fld_pricing'] ?? 0;

        // Fetch portfolio data
        $db = \Config\Database::connect();
        
        // Get portfolio overview from ve_portfolio_overviews table
        $portfolioOverview = $db->table('ve_portfolio_overviews')
            ->where('fld_product_id', $productId)
            ->get()
            ->getRowArray();
        
        // Get portfolio distribution from ve_portfolio_distributions table
        $portfolioDistribution = $db->table('ve_portfolio_distributions')
            ->where('fld_product_id', $productId)
            ->get()
            ->getResultArray();
        
        // Get quarterly updates from ve_quarterly_updates table
        $quarterlyUpdates = $db->table('ve_quarterly_updates')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->get(3) // Limit to 3 records
            ->getResultArray();
        
        // Get latest recommendations (Top 7) from ve_stocks table
        $latestRecommendations = $db->table('ve_stocks')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_date_of_recommendation', 'DESC')
            ->get(4) // Limit to 7 records
            ->getResultArray();
        
        // Get model portfolio from ve_stocks table
        $modelPortfolio = $db->table('ve_stocks')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_date_of_recommendation', 'DESC')
            ->get()
            ->getResultArray();
        
        // Calculate returns for each stock in model portfolio
        foreach ($modelPortfolio as &$stock) {
            // Calculate return percentage
            if ($stock['fld_price_at_recommendation'] > 0) {
                $return = $stock['fld_returns'];
                $stock['return'] = number_format($return, 2);
                $stock['return_class'] = $return >= 0 ? 'green' : 'red';
            } else {
                $stock['return'] = '0.00';
                $stock['return_class'] = 'green';
            }
        }
        
        // Get rebalance timeline from ve_rebalance_timelines table
        $rebalanceTimeline = $db->table('ve_rebalance_timelines')
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_updated_at', 'DESC')
            ->get()
            ->getResultArray();
        
        // Process rebalance timeline to extract items from JSON fields
        foreach ($rebalanceTimeline as &$timeline) {
            // Initialize counts
            $timeline['buy_count'] = 0;
            $timeline['sell_count'] = 0;
            $timeline['items'] = [];
            
            // Check if there are JSON fields containing rebalance items
            // Based on the database structure, we might need to look for fields like:
            // fld_buy_items, fld_sell_items, or similar
            // Since we don't have the exact field names, we'll skip this for now
            
            // If there are fields containing JSON data with items, we would decode them here
            // For example:
            // if (!empty($timeline['fld_buy_items'])) {
            //     $buyItems = json_decode($timeline['fld_buy_items'], true);
            //     $timeline['buy_count'] = count($buyItems);
            //     $timeline['items'] = array_merge($timeline['items'], $buyItems);
            // }
            // if (!empty($timeline['fld_sell_items'])) {
            //     $sellItems = json_decode($timeline['fld_sell_items'], true);
            //     $timeline['sell_count'] = count($sellItems);
            //     $timeline['items'] = array_merge($timeline['items'], $sellItems);
            // }
        }
        
        // Get stock updates
        $stockUpdates = $db->table('ve_stock_updates su')
            ->select('su.*, s.fld_stock_name')
            ->join('ve_stocks s', 'su.fld_stock_id = s.id', 'left')
            ->where('su.fld_product_id', $productId)
            ->where('su.fld_status', 1)
            ->orderBy('su.fld_update_date', 'DESC')
            ->get()
            ->getResultArray();
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'tiny-titans',
            'productPricing' => $productPricing,
            'portfolioOverview' => $portfolioOverview,
            'portfolioDistribution' => $portfolioDistribution,
            'quarterlyUpdates' => $quarterlyUpdates,
            'latestRecommendations' => $latestRecommendations,
            'modelPortfolio' => $modelPortfolio,
            'rebalanceTimeline' => $rebalanceTimeline,
            'stockUpdates' => $stockUpdates,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Tiny Titans Portfolio - Value Educator',
                'description' => 'View your Tiny Titans portfolio with current holdings, performance, and rebalance history.'
            ]
        ];
        
        return view('front/portfolio_tiny_titan', $data);
    }

    public function managementInterviewsEmergingTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Emerging Titans
        $product = $this->productModel->where('fld_slug', 'emerging-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];
                
        if (!$hasAccess) {
            return redirect()->to('/');
        }

        // Fetch all Management Interviews for this product
        $managementInterviews = $this->managementInterviewModel
            ->where('fld_product_id', $productId)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll();
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'emerging-titans',
            'managementInterviews' => $managementInterviews,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Management Interviews - Emerging Titans - Value Educator',
                'description' => 'Access all management interviews for Emerging Titans subscribers.'
            ]
        ];
        
        return view('front/management_interviews_emerging_titan', $data);
    }

    public function managementInterviewsTinyTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Tiny Titans
        $product = $this->productModel->where('fld_slug', 'tiny-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];
        
        if (!$hasAccess) {
            return redirect()->to('/');
        }

        // Fetch all Management Interviews for this product
        $managementInterviews = $this->managementInterviewModel
            ->where('fld_product_id', $productId)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll();
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'tiny-titans',
            'managementInterviews' => $managementInterviews,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Management Interviews - Tiny Titans - Value Educator',
                'description' => 'Access all management interviews for Tiny Titans subscribers.'
            ]
        ];
        
        return view('front/management_interviews_tiny_titan', $data);
    }

    public function quarterlyUpdatesEmergingTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Emerging Titans
        $product = $this->productModel->where('fld_slug', 'emerging-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];
        
        if (!$hasAccess) {
            return redirect()->to('/');
        }

        // Fetch all Quarterly Updates for this product
        $quarterlyUpdates = $this->quarterlyUpdateModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll();
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'emerging-titans',
            'quarterlyUpdates' => $quarterlyUpdates,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Quarterly Model Portfolio Updates - Emerging Titans - Value Educator',
                'description' => 'Access all quarterly model portfolio updates for Emerging Titans subscribers.'
            ]
        ];
        
        return view('front/quarterly_updates_emerging_titan', $data);
    }

    public function quarterlyUpdatesTinyTitan()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get product details for Tiny Titans
        $product = $this->productModel->where('fld_slug', 'tiny-titans')->first();
        
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        
        $productId = $product['id'];
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess($productId);
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        $showSubscriptionExpiredModal = $accessStatus['showSubscriptionExpiredModal'];
        $expiredProducts = $accessStatus['expiredProducts'];
        
        if (!$hasAccess) {
            return redirect()->to('/');
        }
        
        // Fetch all Quarterly Updates for this product
        $quarterlyUpdates = $this->quarterlyUpdateModel
            ->where('fld_product_id', $productId)
            ->where('fld_status', 1)
            ->orderBy('fld_created_at', 'DESC')
            ->findAll();
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'product' => $product,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'showSubscriptionExpiredModal' => $showSubscriptionExpiredModal,
            'expiredProducts' => $expiredProducts,
            'currentProduct' => 'tiny-titans',
            'quarterlyUpdates' => $quarterlyUpdates,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Quarterly Model Portfolio Updates - Tiny Titans - Value Educator',
                'description' => 'Access all quarterly model portfolio updates for Tiny Titans subscribers.'
            ]
        ];
        
        return view('front/quarterly_updates_tiny_titan', $data);
    }

    public function youtubeVideos()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get user subscription status
        $hasAccess = true;
        
        // Pagination parameters
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 2; // Show 12 videos per page
        $offset = ($page - 1) * $perPage;
        
        // Get total count for pagination
        $totalVideos = $this->youtubeVideoModel
            ->where('fld_status', 1)
            ->countAllResults();
        
        // Fetch paginated YouTube Videos
        $youtubeVideos = $this->youtubeVideoModel
            ->where('fld_status', 1)
            ->orderBy('fld_posted_at', 'DESC')
            ->findAll($perPage, $offset);
        
        // Create pagination links
        $pager = \Config\Services::pager();
        $pagination = $pager->makeLinks($page, $perPage, $totalVideos, 'default_full');
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'hasAccess' => $hasAccess,
            'youtubeVideos' => $youtubeVideos,
            'allProducts' => $allProducts,
            'pagination' => $pagination,
            'currentPage' => $page,
            'totalVideos' => $totalVideos,
            'perPage' => $perPage,
            'meta' => [
                'title' => 'YouTube Videos - Value Educator',
                'description' => 'Access all our educational YouTube videos on investing, market analysis, and more.'
            ]
        ];
        
        return view('front/youtube_videos', $data);
    }

    public function substackUpdates()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get user subscription status (placeholder)
        $hasAccess = true; // Substack updates might be accessible to all users
        
        // Fetch all Substack Updates with product names
        $substackUpdateModel = new \App\Models\SubstackUpdateModel();
        $substackUpdates = $substackUpdateModel->getUpdatesWithProductNames();
        
        // Pre-calculate time elapsed for each update
        foreach ($substackUpdates as &$update) {
            $update['time_elapsed'] = $this->timeElapsedString(strtotime($update['fld_posted_at']));
        }
        
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'hasAccess' => $hasAccess,
            'substackUpdates' => $substackUpdates,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Substack Updates - Value Educator',
                'description' => 'Access all our Substack articles and updates on investing, market analysis, and more.'
            ]
        ];
        
        return view('front/substack_updates', $data);
    }

    public function getScuttlebuttNotes($productId)
    {
        // Block non-AJAX access
        if (! $this->request->isAJAX()) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Direct access not allowed'
                ]);
        }

        // Check if user is logged in
        if (! session()->get('isLoggedIn')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['message' => 'Unauthorized']);
        }

        $scuttlebuttNotesModel = new \App\Models\ScuttlebuttNotesModel();
        $notes = $scuttlebuttNotesModel->getActiveNotesByProductId($productId);
        
        return $this->response->setJSON($notes);
    }

    public function getStockUpdates($productId, $stockId)
    {
        // Block non-AJAX access
        if (! $this->request->isAJAX()) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Direct access not allowed'
                ]);
        }

        // Check if user is logged in
        if (! session()->get('isLoggedIn')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['message' => 'Unauthorized']);
        }
        
        $stockUpdateModel = new \App\Models\StockUpdateModel();
        $notes = $stockUpdateModel->getStockUpdateByStockId($productId, $stockId);
        
        return $this->response->setJSON($notes);
    }
}