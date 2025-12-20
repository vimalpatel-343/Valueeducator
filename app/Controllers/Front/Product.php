<?php
namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductFeatureModel;
use App\Models\AppImageModel;

class Product extends BaseController
{
    protected $productModel;
    protected $productFeatureModel;
    protected $appImageModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productFeatureModel = new ProductFeatureModel();
        $this->appImageModel = new AppImageModel();
    }
    
    public function index($slug = null)
    {
        if (!$slug) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Get product by slug
        $product = $this->productModel->getProductBySlug($slug);
        
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Get product features
        $features = $this->productFeatureModel->getFeaturesByProductId($product['id']);
        
        // Get app images
        $appImages = $this->appImageModel->getImagesByProductId($product['id']);
        
        // Get all products for comparison section
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings'  => $this->getSiteSettings(),
            'product' => $product,
            'features' => $features,
            'appImages' => $appImages,
            'allProducts' => $allProducts
        ];
        
        // Set meta tags
        $title = $data['product']['fld_title'] . ' - ' . $data['siteSettings']['fld_site_title']. ' Product';
        $description = 'Explore detailed information, features, pricing, and benefits of ' 
                        . $data['product']['fld_title'] 
                        . '. Learn how this product can help.';

        $data['meta'] = [
            'title' => $title,
            'description' => $description,
            'keywords' => $data['product']['fld_title'] . ', product details, product features, product specifications, pricing, benefits'
        ];

        if ($slug === 'tiny-titans') {
            return view('front/product/tiny_titans', $data);
        } else {
            return view('front/product/emerging-titans', $data);
        }
    }

    private function generateMetaDescription($content)
    {
        // Strip HTML tags and limit to 160 characters
        $plainText = strip_tags($content);
        if (strlen($plainText) > 160) {
            return substr($plainText, 0, 157) . '...';
        }
        return $plainText;
    }
}