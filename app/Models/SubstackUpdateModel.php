<?php

namespace App\Models;

use CodeIgniter\Model;

class SubstackUpdateModel extends Model
{
    protected $table = 've_substack_updates';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_ids', 'fld_title', 'fld_description', 'fld_image', 
        'fld_url', 'fld_posted_at', 'fld_status'
    ];
    
    // Get all active substack updates
    public function getActiveUpdates()
    {
        return $this->where('fld_status', 1)
                    ->orderBy('fld_posted_at', 'DESC')
                    ->findAll();
    }
    
    // Get updates by product ID
    public function getUpdatesByProductId($productId)
    {
        return $this->where('fld_status', 1)
                    ->like('fld_product_ids', $productId)
                    ->orderBy('fld_posted_at', 'DESC')
                    ->findAll();
    }
    
    // Get updates with product names
    public function getUpdatesWithProductNames()
    {
        $updates = $this->where('fld_status', 1)
                      ->orderBy('fld_posted_at', 'DESC')
                      ->findAll();
        
        // Get all products
        $productModel = new ProductModel();
        $allProducts = $productModel->findAll();
        $productMap = [];
        foreach ($allProducts as $product) {
            $productMap[$product['id']] = $product['fld_title'];
        }
        
        // Add product names to each update
        foreach ($updates as &$update) {
            $productIds = !empty($update['fld_product_ids']) ? explode(',', $update['fld_product_ids']) : [];
            $productNames = [];
            foreach ($productIds as $productId) {
                if (isset($productMap[$productId])) {
                    $productNames[] = $productMap[$productId];
                }
            }
            $update['product_names'] = implode(', ', $productNames);
        }
        
        return $updates;
    }
}