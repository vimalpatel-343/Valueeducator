<?php
namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\KnowledgeCategoryModel;
use App\Models\KnowledgeItemModel;
use App\Models\SiteSettingsModel;
use App\Models\YoutubeVideoModel;
use App\Models\ProductModel;
use App\Models\UserSubscriptionModel;
use App\Models\UserModel;

class Knowledge extends BaseController
{
    protected $knowledgeCategoryModel;
    protected $knowledgeItemModel;
    protected $siteSettingsModel;
    protected $youtubeVideoModel;
    protected $productModel;
    protected $userSubscriptionModel;
    protected $userModel;

    public function __construct()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        helper('common');
        
        $this->knowledgeCategoryModel = new KnowledgeCategoryModel();
        $this->knowledgeItemModel = new KnowledgeItemModel();
        $this->siteSettingsModel = new SiteSettingsModel();
        $this->youtubeVideoModel = new YoutubeVideoModel();
        $this->productModel = new ProductModel();
        $this->userSubscriptionModel = new UserSubscriptionModel();
        $this->userModel = new UserModel();
    }

    // Modified function to check both subscription and KYC status
    private function checkAccess()
    {
        if (!session()->get('isLoggedIn')) {
            return [
                'hasAccess' => false,
                'reason' => 'not_logged_in',
                'showKycModal' => false
            ];
        }

        $userId = session()->get('userId');
        $userSubscriptionModel = new \App\Models\UserSubscriptionModel();
        
        // Check subscription status
        $hasSubscription = $userSubscriptionModel->hasActiveSubscription($userId);
        
        // If no subscription, no need to check KYC
        if (!$hasSubscription) {
            return [
                'hasAccess' => false,
                'reason' => 'subscription',
                'showKycModal' => false
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
            'showKycModal' => !$hasKyc
        ];
    }

    public function index()
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Set meta data
        $meta = [
            'title' => 'Knowledge Centre - Value Educator',
            'description' => 'Access our collection of educational resources, including fundamental analysis, sector information, management interviews, reports, case studies, and management meet notes.'
        ];
        
        // Get all active categories
        $categories = $this->knowledgeCategoryModel->where('fld_status', 1)->findAll();
        
        // Get YouTube videos
        $videos = $this->youtubeVideoModel->getActiveVideos(5);

        // Get all products for comparison section
        $allProducts = $this->productModel->getAllActiveProducts();
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess();
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        
        // If user has access, get all knowledge items
        if ($hasAccess) {
            // Get all items across all categories
            $allItems = $this->knowledgeItemModel
                        ->where('fld_status', 1)
                        ->orderBy('fld_posted_at', 'DESC')
                        ->findAll();
            
            // Group items by category
            $itemsByCategory = [];
            foreach ($allItems as $item) {
                $itemsByCategory[$item['fld_category_id']][] = $item;
            }
        } else {
            // For non-subscribers, we'll show limited data
            $itemsByCategory = [];
            
            // Get just a few items from each category to show as teasers
            foreach ($categories as $category) {
                $teaserItems = $this->knowledgeItemModel
                                ->where('fld_category_id', $category['id'])
                                ->where('fld_status', 1)
                                ->orderBy('fld_posted_at', 'DESC')
                                ->findAll(1); // Just one item per category as teaser
                
                if (!empty($teaserItems)) {
                    $itemsByCategory[$category['id']] = $teaserItems;
                }
            }
        }

        // Fetch all Substack Updates with product names
        $substackUpdateModel = new \App\Models\SubstackUpdateModel();
        $substackUpdates = $substackUpdateModel->getUpdatesWithProductNames(3);
        
        $data = [
            'meta' => $meta,
            'siteSettings' => $siteSettings,
            'categories' => $categories,
            'videos' => $videos,
            'allProducts' => $allProducts,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
            'substackUpdates' => $substackUpdates,
            'itemsByCategory' => $itemsByCategory
        ];
        
        return view('front/knowledge/index', $data);
    }
    
    public function category($slug)
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Check both subscription and KYC status
        $accessStatus = $this->checkAccess();
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        
        if (!$hasAccess) {
            return redirect()->to('/');
        }

        // Get category by slug
        $category = $this->knowledgeCategoryModel->where('fld_slug', $slug)->where('fld_status', 1)->first();
        
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Set meta data
        $meta = [
            'title' => $category['fld_title'] . ' - Knowledge Centre - Value Educator',
            'description' => 'Explore our collection of ' . $category['fld_title'] . ' resources at Value Educator.'
        ];
        
        // Get items for this category
        if ($hasAccess) {
            // Full access to all items in this category
            $items = $this->knowledgeItemModel
                        ->where('fld_category_id', $category['id'])
                        ->where('fld_status', 1)
                        ->orderBy('fld_posted_at', 'DESC')
                        ->findAll();
        } else {
            // Limited access - just show a few items as teasers
            $items = $this->knowledgeItemModel
                        ->where('fld_category_id', $category['id'])
                        ->where('fld_status', 1)
                        ->orderBy('fld_posted_at', 'DESC')
                        ->findAll(2); // Just 2 items as teasers
        }
        
        $data = [
            'meta' => $meta,
            'siteSettings' => $siteSettings,
            'category' => $category,
            'items' => $items,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
        ];
        
        if($slug == 'reports' || $slug == 'sector-information' || $slug == 'management-meet-notes')
        {
            return view('front/under-development', $data);
        }
        else
        {
            return view('front/knowledge/category', $data);
        }
    }
    
    public function item($categoryId, $itemId)
    {
        // Check if user is logged in
        if (! session()->has('isLoggedIn') || session()->get('isLoggedIn') !== true) {
            return redirect()->to('/');
        }

        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Check if user has access to any product
        $accessStatus = $this->checkAccess();
        $hasAccess = $accessStatus['hasAccess'];
        $showKycModal = $accessStatus['showKycModal'];
        
        if (!$hasAccess) {
            // Redirect to login or show subscription prompt
            return redirect()->to('/login')->with('error', 'Please login and subscribe to access this content');
        }
        
        // Get the knowledge item
        $item = $this->knowledgeItemModel
                ->where('id', $itemId)
                ->where('fld_category_id', $categoryId)
                ->where('fld_status', 1)
                ->first();
        
        if (!$item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Get category
        $category = $this->knowledgeCategoryModel->find($categoryId);
        
        // Set meta data
        $meta = [
            'title' => $item['fld_title'] . ' - ' . $category['fld_title'] . ' - Knowledge Centre - Value Educator',
            'description' => substr(strip_tags($item['fld_description']), 0, 160) . '...'
        ];
        
        // Get related items (same category, different ID)
        $relatedItems = $this->knowledgeItemModel
                        ->where('fld_category_id', $categoryId)
                        ->where('id !=', $itemId)
                        ->where('fld_status', 1)
                        ->orderBy('fld_posted_at', 'DESC')
                        ->findAll(3);
        
        $data = [
            'meta' => $meta,
            'siteSettings' => $siteSettings,
            'category' => $category,
            'item' => $item,
            'relatedItems' => $relatedItems,
            'hasAccess' => $hasAccess,
            'showKycModal' => $showKycModal,
        ];
        
        return view('front/knowledge/item', $data);
    }    
}