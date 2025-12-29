<?php
namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\InvestmentPhilosophyModel;
use App\Models\ProductModel;
use App\Models\ProductFeatureModel;
use App\Models\AppImageModel;
use App\Models\YoutubeVideoModel;
use App\Models\SiteSettingsModel;

class Home extends BaseController
{
    protected $investmentPhilosophyModel;
    protected $productModel;
    protected $productFeatureModel;
    protected $appImageModel;
    protected $youtubeVideoModel;
    protected $siteSettingsModel;

    public function __construct()
    {
        helper('common');
        
        $this->investmentPhilosophyModel = new InvestmentPhilosophyModel();
        $this->productModel = new ProductModel();
        $this->productFeatureModel = new ProductFeatureModel();
        $this->appImageModel = new AppImageModel();
        $this->youtubeVideoModel = new YoutubeVideoModel();
        $this->siteSettingsModel = new SiteSettingsModel();
    }

    public function index()
    {
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Set meta data
        $meta = [
            'title' => 'Value Educator - Your Partner in Building Sustainable Wealth',
            'description' => 'Value Educator is your dedicated partner in building sustainable wealth, specializing in uncovering undervalued stocks.'
        ];
        
        // Get investment philosophies
        $philosophies = $this->investmentPhilosophyModel->getActivePhilosophies();
        
        // Get products
        $products = $this->productModel->getAllActiveProducts();
        
        // Get product features for all products
        $productFeatures = [];
        $appImages = [];
        foreach ($products as $product) {
            $productFeatures[$product['id']] = $this->productFeatureModel->getFeaturesByProductId($product['id']);
            $appImages[$product['id']] = $this->appImageModel->getImagesByProductId($product['id']);
        }
        
        // Get YouTube videos
        $videos = $this->youtubeVideoModel->getActiveVideos(5);
        
        // Process videos to extract video ID and generate thumbnail URL
        foreach ($videos as &$video) {
            $videoId = $video['fld_video_id'];
            $video['video_id'] = $videoId;
            $video['thumbnail'] = $videoId ? 'https://img.youtube.com/vi/' . $videoId . '/maxresdefault.jpg' : 'https://via.placeholder.com/300x200?text=No+Thumbnail';
        }
        
        // Get user subscriptions
        $userSubscriptions = $this->getUserSubscriptions();

        $data = [
            'meta' => $meta,
            'siteSettings' => $siteSettings,
            'philosophies' => $philosophies,
            'products' => $products,
            'productFeatures' => $productFeatures,
            'appImages' => $appImages,
            'videos' => $videos,
            'userSubscriptions' => $userSubscriptions
        ];
        
        return view('front/home/index', $data);
    }
    
}