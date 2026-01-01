<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\YoutubeVideoModel;
use App\Models\ProductModel;

class YoutubeVideo extends BaseController
{
    protected $videoModel;
    protected $productModel;
    
    public function __construct()
    {
        $this->videoModel = new YoutubeVideoModel();
        $this->productModel = new ProductModel();
        helper('text');
    }
    
    // List all YouTube videos with pagination
    public function index()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        
        $data['videos'] = $this->videoModel->getAllVideos($perPage, $offset);
        $data['totalVideos'] = $this->videoModel->countAllVideos();
        $data['pager'] = \Config\Services::pager();
        $data['currentPage'] = $page;
        $data['perPage'] = $perPage;
        $data['title'] = 'YouTube Videos';
        
        return view('admin/youtube_video/index', $data);
    }
    
    // Show form to create new video
    public function create()
    {
        $data['products'] = $this->productModel->getActiveProducts();
        $data['title'] = 'Create YouTube Video';
        
        return view('admin/youtube_video/create', $data);
    }
    
    // Store new video
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'video_id' => 'required|min_length[11]|max_length[11]',
            'assignments' => 'required',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $videoId = $this->request->getPost('video_id');
        
        // Get video details from YouTube API
        $videoDetails = $this->videoModel->getVideoDetailsFromAPI($videoId);
        
        if (!$videoDetails) {
            return redirect()->back()->withInput()->with('error', 'Invalid YouTube video ID or unable to fetch video details');
        }
        
        $data = [
            'fld_title' => $videoDetails['title'],
            'fld_description' => $videoDetails['description'],
            'fld_video_id' => $videoId,
            'fld_total_views' => $videoDetails['total_views'],
            'fld_posted_at' => $videoDetails['posted_at'],
            'fld_status' => $this->request->getPost('status')
        ];
        
        // Get selected assignments (general and/or products)
        $assignments = $this->request->getPost('assignments') ?? [];
        
        $this->videoModel->createVideo($data, $assignments);
        
        return redirect()->to('/admin/youtube-videos')->with('success', 'YouTube video added successfully');
    }
    
    // Show form to edit video
    public function edit($id)
    {
        $data['video'] = $this->videoModel->getVideoById($id);
        $data['products'] = $this->productModel->getActiveProducts();
        
        if (empty($data['video'])) {
            return redirect()->to('/admin/youtube-videos')->with('error', 'YouTube video not found');
        }
        
        $data['title'] = 'Edit YouTube Video';
        
        return view('admin/youtube_video/edit', $data);
    }
    
    // Update video
    public function update($id)
    {
        $video = $this->videoModel->getVideoById($id);
        
        if (empty($video)) {
            return redirect()->to('/admin/youtube-videos')->with('error', 'YouTube video not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => 'required|min_length[3]',
            'description' => 'required',
            'assignments' => 'required',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'fld_title' => $this->request->getPost('title'),
            'fld_description' => $this->request->getPost('description'),
            'fld_total_views' => $this->request->getPost('total_views'),
            'fld_posted_at' => $this->request->getPost('posted_at'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        // Get selected assignments (general and/or products)
        $assignments = $this->request->getPost('assignments') ?? [];
        
        $this->videoModel->updateVideo($id, $data, $assignments);
        
        return redirect()->to('/admin/youtube-videos')->with('success', 'YouTube video updated successfully');
    }
    
    // Delete video
    public function delete($id)
    {
        $video = $this->videoModel->getVideoById($id);
        
        if (empty($video)) {
            return redirect()->to('/admin/youtube-videos')->with('error', 'YouTube video not found');
        }
        
        $this->videoModel->deleteVideo($id);
        
        return redirect()->to('/admin/youtube-videos')->with('success', 'YouTube video deleted successfully');
    }
    
    // Refresh video data from YouTube API
    public function refresh($id)
    {
        $video = $this->videoModel->getVideoById($id);
        
        if (empty($video)) {
            return redirect()->to('/admin/youtube-videos')->with('error', 'YouTube video not found');
        }
        
        // Get updated video details from YouTube API
        $videoDetails = $this->videoModel->getVideoDetailsFromAPI($video['fld_video_id']);
        
        if (!$videoDetails) {
            return redirect()->to('/admin/youtube-videos')->with('error', 'Unable to fetch updated video details');
        }
        
        $data = [
            'fld_title' => $videoDetails['title'],
            'fld_description' => $videoDetails['description'],
            'fld_total_views' => $videoDetails['total_views'],
            'fld_posted_at' => $videoDetails['posted_at']
        ];
        
        $this->videoModel->update($id, $data);
        
        return redirect()->to('/admin/youtube-videos')->with('success', 'Video data refreshed successfully');
    }
}