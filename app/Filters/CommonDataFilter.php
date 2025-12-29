<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CommonDataFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Load models
        $siteSettingsModel = new \App\Models\SiteSettingsModel();
        $productModel = new \App\Models\ProductModel();
        $pageImageModel = new \App\Models\PageImageModel();
        
        // Get site settings
        $siteSettings = $siteSettingsModel->first();
        
        // Get all active products
        $allProducts = $productModel->getAllActiveProducts();

        // Get page images grouped by page
        $pageImages = $pageImageModel->getImagesGroupedByPage();
        //echo "<pre>"; print_R($pageImages); die;
        
        // Get user subscriptions if logged in
        $userSubscriptions = [];
        if (session()->get('isLoggedIn')) {
            $userSubscriptionModel = new \App\Models\UserSubscriptionModel();
            $userSubscriptions = $userSubscriptionModel->getUserSubscriptions(session()->get('userId'));
        }
        
        // Share data with all views
        service('renderer')->setData([
            'siteSettings' => $siteSettings,
            'allProducts' => $allProducts,
            'pageImages' => $pageImages,
            'userSubscriptions' => $userSubscriptions
        ]);
        
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}