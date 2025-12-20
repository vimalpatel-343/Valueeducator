<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\UserSubscriptionModel;
use App\Models\ProductModel;

class BaseProductController extends BaseController
{
    protected $userSubscriptionModel;
    protected $productModel;
    
    public function __construct()
    {
        $this->userSubscriptionModel = new UserSubscriptionModel();
        $this->productModel = new ProductModel();
        helper('text');
    }
    
    // Check if user has access to the product
    protected function checkProductAccess($productSlug)
    {
        $userId = session()->get('userId');
        
        if (!$userId) {
            return [
                'hasAccess' => false,
                'product' => $this->productModel->where('fld_slug', $productSlug)->first()
            ];
        }
        
        $subscription = $this->userSubscriptionModel->hasActiveSubscriptionBySlug($userId, $productSlug);
        $product = $this->userSubscriptionModel->getProductBySlug($productSlug);
        
        return [
            'hasAccess' => !empty($subscription),
            'product' => $product,
            'subscription' => $subscription
        ];
    }
}