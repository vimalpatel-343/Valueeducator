<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 've_products';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_title', 'fld_slug', 'fld_description', 'fld_description_paid', 'fld_video_url', 'fld_how_to_use_url', 'fld_research_framework', 'fld_market_cap_focus', 'fld_no_of_ideas', 'fld_holding_period', 'fld_minimum_investment', 'fld_rebalance_frequency', 'fld_next_rebalance', 'fld_pricing', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get all active products
    public function getActiveProducts()
    {
        return $this->where('fld_status', 1)->findAll();
    }
    
    // Get all products with features
    public function getAllProductsWithFeatures()
    {
        return $this->select('ve_products.*, COUNT(ve_product_features.id) as feature_count')
                    ->join('ve_product_features', 've_product_features.fld_product_id = ve_products.id', 'left')
                    ->groupBy('ve_products.id')
                    ->findAll();
    }
    
    public function getAllActiveProducts()
    {
        $products = $this->where('fld_status', 1)->findAll();
        
        // Add features and images to each product
        foreach ($products as &$product) {
            // Get product features
            $featuresModel = new ProductFeatureModel();
            $product['features'] = $featuresModel->where('fld_product_id', $product['id'])->findAll();
            
            // Get product images
            $imagesModel = new AppImageModel();
            $product['images'] = $imagesModel->where('fld_product_id', $product['id'])->orderBy('fld_display_order', 'ASC')->findAll();
            
            // Convert image paths to simple array
            $imagePaths = [];
            foreach ($product['images'] as $image) {
                $imagePaths[] = $image['fld_image'];
            }
            $product['images'] = $imagePaths;
        }
        
        return $products;
    }

    public function getProductBySlug($slug)
    {
        $product = $this->where('fld_slug', $slug)->where('fld_status', 1)->first();
        
        if ($product) {
            // Get product features
            $featuresModel = new ProductFeatureModel();
            $product['features'] = $featuresModel->where('fld_product_id', $product['id'])->findAll();
            
            // Get product images
            $imagesModel = new AppImageModel();
            $product['images'] = $imagesModel->where('fld_product_id', $product['id'])->orderBy('fld_display_order', 'ASC')->findAll();
            
            // Convert image paths to simple array
            $imagePaths = [];
            foreach ($product['images'] as $image) {
                $imagePaths[] = $image['fld_image'];
            }
            $product['images'] = $imagePaths;
        }
        
        return $product;
    }
}