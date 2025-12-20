<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContentPagesModel;

class ComplaintData extends BaseController
{
    protected $contentModel;
    
    public function __construct()
    {
        $this->contentModel = new ContentPagesModel();
        helper('text');
    }
    
    // Show Complaint Data form
    public function index()
    {
        $data['content'] = $this->contentModel->getContentByType('complaint_data');
        $data['title'] = 'Complaint Data';
        
        return view('admin/complaint_data/index', $data);
    }
    
    // Update Complaint Data
    public function update()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $content = $this->contentModel->getContentByType('complaint_data');
        
        if ($content) {
            // Update existing content
            $data = [
                'fld_title' => $this->request->getPost('title'),
                'fld_content' => $this->request->getPost('content'),
                'fld_status' => $this->request->getPost('status')
            ];
            
            $this->contentModel->updateContent($content['id'], $data);
        } else {
            // Create new content
            $data = [
                'fld_page_type' => 'complaint_data',
                'fld_title' => $this->request->getPost('title'),
                'fld_content' => $this->request->getPost('content'),
                'fld_status' => $this->request->getPost('status')
            ];
            
            $this->contentModel->createContent($data);
        }
        
        return redirect()->to('/admin/complaint-data')->with('success', 'Complaint Data updated successfully');
    }
}