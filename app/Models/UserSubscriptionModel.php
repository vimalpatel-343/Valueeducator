<?php
namespace App\Models;

use CodeIgniter\Model;

class UserSubscriptionModel extends Model
{
    protected $table = 've_user_subscriptions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id', 
        'product_id', 
        'subscription_type', 
        'amount', 
        'start_date', 
        'end_date', 
        'status'
    ];

    // Get active subscription for a user
    public function getActiveSubscription($userId, $productId = null)
    {
        $builder = $this->where('user_id', $userId)
                        ->where('status', 1)
                        ->where('end_date >=', date('Y-m-d'));
        
        if ($productId) {
            $builder = $builder->where('product_id', $productId);
        }
        
        return $builder->first();
    }

    // Check if user has active subscription for a product
    public function hasActiveSubscription($userId, $productId=null)
    {
        $subscription = $this->getActiveSubscription($userId, $productId);
        return !empty($subscription);
    }

    // Get user subscriptions with product details
    public function getUserSubscriptions($userId)
    {
        $this->select('ve_user_subscriptions.*, ve_products.fld_title as product_name, ve_products.fld_slug as product_slug');
        $this->join('ve_products', 've_products.id = ve_user_subscriptions.product_id');
        $this->where('ve_user_subscriptions.user_id', $userId);
        $this->where('ve_user_subscriptions.status', 1); // Active subscriptions
        $this->where('ve_user_subscriptions.end_date >=', date('Y-m-d')); // Not expired
        return $this->findAll();
    }

    // Check if user has active subscription for a product by slug
    public function hasActiveSubscriptionBySlug($userId, $productSlug)
    {
        $productModel = new ProductModel();
        $product = $productModel->where('fld_slug', $productSlug)->first();
        
        if (!$product) {
            return false;
        }
        
        return $this->where('user_id', $userId)
                    ->where('product_id', $product['id'])
                    ->where('status', 1)
                    ->where('end_date >=', date('Y-m-d'))
                    ->first();
    }
    
    // Get product details by slug
    public function getProductBySlug($productSlug)
    {
        $productModel = new ProductModel();
        return $productModel->where('fld_slug', $productSlug)->first();
    }
}