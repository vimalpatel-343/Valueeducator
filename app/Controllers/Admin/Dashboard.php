<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\StockModel;
use App\Models\YoutubeVideoModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if user is admin
        if (!session()->get('isAdmin')) {
            return redirect()->to('/auth')->with('error', 'You do not have permission to access the admin area.');
        }
        
        // Get statistics for dashboard
        $userModel = new UserModel();
        $productModel = new ProductModel();
        $stockModel = new StockModel();
        $youtubeModel = new YoutubeVideoModel();
        
        // Get user count
        $data['userCount'] = $userModel->countAll();
        
        // Get product count
        $data['productCount'] = $productModel->countAll();
        
        // Get stock count
        $data['stockCount'] = $stockModel->countAll();
        
        // Get YouTube video count
        $data['videoCount'] = $youtubeModel->countAll();
        
        // Get recent users
        $data['recentUsers'] = $userModel->orderBy('id', 'DESC')->limit(5)->find();
        
        // Get recent products
        $data['recentProducts'] = $productModel->orderBy('id', 'DESC')->limit(5)->find();
        
        // Get recent stocks
        $data['recentStocks'] = $stockModel->orderBy('id', 'DESC')->limit(5)->find();
        
        // Get recent videos
        $data['recentVideos'] = $youtubeModel->orderBy('id', 'DESC')->limit(5)->find();
        
        return view('admin/dashboard', $data);
    }
}