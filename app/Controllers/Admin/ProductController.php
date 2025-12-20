<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $productModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }
    
    // This method will handle all dynamic product routes
    public function index($slug = null, $page = null)
    {
        if (!$slug) {
            return redirect()->to('/admin/dashboard');
        }
        
        // Find the product by slug
        $product = $this->productModel->where('fld_slug', $slug)->first();
        
        if (!$product) {
            return redirect()->to('/admin/dashboard')->with('error', 'Product not found');
        }
        
        // Determine which page to show
        switch ($page) {
            case 'dashboard':
                return $this->dashboard($product);
            case 'basic-details':
                return $this->basicDetails($product);
            case 'stocks':
                return $this->stocks($product);
            case 'portfolio':
                return $this->portfolio($product);
            case 'updates':
                return $this->updates($product);
            default:
                return $this->dashboard($product);
        }
    }
    
    protected function dashboard($product)
    {
        $data['product'] = $product;
        $data['title'] = $product['fld_title'] . ' - Dashboard';
        
        return view('admin/product/dashboard', $data);
    }
    
    protected function basicDetails($product)
    {
        $data['product'] = $product;
        $data['title'] = $product['fld_title'] . ' - Basic Details';
        
        return view('admin/product/basic_details', $data);
    }
    
    protected function stocks($product)
    {
        $data['product'] = $product;
        $data['title'] = $product['fld_title'] . ' - Stocks';
        
        return view('admin/product/stocks', $data);
    }
    
    protected function portfolio($product)
    {
        $data['product'] = $product;
        $data['title'] = $product['fld_title'] . ' - Portfolio';
        
        return view('admin/product/portfolio', $data);
    }
    
    protected function updates($product)
    {
        $data['product'] = $product;
        $data['title'] = $product['fld_title'] . ' - Updates';
        
        return view('admin/product/updates', $data);
    }
}