<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\InvestmentPhilosophyModel;
use App\Models\SiteSettingsModel;
use App\Models\ProductModel;

class InvestmentPhilosophyController extends BaseController
{
    protected $philosophyModel;
    protected $siteSettingsModel;
    protected $productModel;

    public function __construct()
    {
        $this->philosophyModel = new InvestmentPhilosophyModel();
        $this->siteSettingsModel = new SiteSettingsModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // Get site settings
        $siteSettings = $this->siteSettingsModel->first();
        
        // Get all active investment philosophies
        $philosophies = $this->philosophyModel->getActivePhilosophies();
        
        // Get all products for the footer
        $allProducts = $this->productModel->getAllActiveProducts();
        
        $data = [
            'siteSettings' => $siteSettings,
            'philosophies' => $philosophies,
            'allProducts' => $allProducts,
            'meta' => [
                'title' => 'Investment Philosophy - Value Educator',
                'description' => 'Learn about our SPRINT investment philosophy focused on sustainable growth and value creation.'
            ]
        ];
        
        return view('front/investment_philosophy', $data);
    }
}