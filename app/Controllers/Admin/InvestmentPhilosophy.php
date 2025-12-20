<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InvestmentPhilosophyModel;

class InvestmentPhilosophy extends BaseController
{
    protected $philosophyModel;
    
    public function __construct()
    {
        $this->philosophyModel = new InvestmentPhilosophyModel();
    }
    
    // List all investment philosophies
    public function index()
    {
        $data['philosophies'] = $this->philosophyModel->findAll();
        $data['title'] = 'Investment Philosophy';
        
        return view('admin/investment_philosophy/index', $data);
    }
    
    // Show form to create new philosophy
    public function create()
    {
        $data['title'] = 'Create Investment Philosophy';
        
        return view('admin/investment_philosophy/create', $data);
    }
    
    // Store new philosophy
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => 'required|min_length[3]|max_length[100]',
            'description' => 'required|min_length[10]',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Handle main image upload
        $image = '';
        if ($file = $this->request->getFile('image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/investment_philosophy', $newName);
                $image = 'uploads/investment_philosophy/' . $newName;
            }
        }
        
        // Handle multiple images upload (exactly 3 slots)
        $multipleImages = [];
        if ($files = $this->request->getFiles()) {
            if (isset($files['images']) && is_array($files['images'])) {
                foreach ($files['images'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move('uploads/investment_philosophy', $newName);
                        $multipleImages[] = 'uploads/investment_philosophy/' . $newName;
                    }
                }
            }
        }
        
        // Process services data
        $services = [];
        $serviceIcons = $this->request->getPost('service_icon');
        $serviceTitles = $this->request->getPost('service_title');
        $serviceDescriptions = $this->request->getPost('service_description');
        
        if (is_array($serviceIcons) && is_array($serviceTitles) && is_array($serviceDescriptions)) {
            $count = min(count($serviceIcons), count($serviceTitles), count($serviceDescriptions));
            
            for ($i = 0; $i < $count; $i++) {
                if (!empty($serviceIcons[$i]) && !empty($serviceTitles[$i]) && !empty($serviceDescriptions[$i])) {
                    $services[] = [
                        'icon_name' => $serviceIcons[$i],
                        'service_title' => $serviceTitles[$i],
                        'service_description' => $serviceDescriptions[$i]
                    ];
                }
            }
        }
        
        $data = [
            'fld_title' => $this->request->getPost('title'),
            'fld_description' => $this->request->getPost('description'),
            'fld_image' => $image,
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->philosophyModel->createPhilosophy($data, $services, $multipleImages);
        
        return redirect()->to('/admin/investment-philosophy')->with('success', 'Investment philosophy created successfully');
    }
    
    // Show form to edit philosophy
    public function edit($id)
    {
        $data['philosophy'] = $this->philosophyModel->getPhilosophyById($id);
        
        if (empty($data['philosophy'])) {
            return redirect()->to('/admin/investment-philosophy')->with('error', 'Investment philosophy not found');
        }
        
        $data['title'] = 'Edit Investment Philosophy';
        
        return view('admin/investment_philosophy/edit', $data);
    }
    
    // Update philosophy
    public function update($id)
    {
        $philosophy = $this->philosophyModel->getPhilosophyById($id);
        
        if (empty($philosophy)) {
            return redirect()->to('/admin/investment-philosophy')->with('error', 'Investment philosophy not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => 'required|min_length[3]|max_length[100]',
            'description' => 'required|min_length[10]',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Handle main image upload
        $image = $philosophy['fld_image'];
        if ($file = $this->request->getFile('image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Delete old image if exists
                if (!empty($philosophy['fld_image']) && file_exists($philosophy['fld_image'])) {
                    unlink($philosophy['fld_image']);
                }
                
                $newName = $file->getRandomName();
                $file->move('uploads/investment_philosophy', $newName);
                $image = 'uploads/investment_philosophy/' . $newName;
            }
        }
        
        // Handle multiple images upload (exactly 3 slots)
        $multipleImages = [];
        
        // First, get existing images that weren't deleted
        if (!empty($philosophy['images'])) {
            foreach ($philosophy['images'] as $img) {
                $multipleImages[] = $img['image_path'];
            }
        }
        
        // Then add any new images
        if ($files = $this->request->getFiles()) {
            if (isset($files['images']) && is_array($files['images'])) {
                foreach ($files['images'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move('uploads/investment_philosophy', $newName);
                        $multipleImages[] = 'uploads/investment_philosophy/' . $newName;
                    }
                }
            }
        }
        
        // Process services data
        $services = [];
        $serviceIcons = $this->request->getPost('service_icon');
        $serviceTitles = $this->request->getPost('service_title');
        $serviceDescriptions = $this->request->getPost('service_description');
        
        if (is_array($serviceIcons) && is_array($serviceTitles) && is_array($serviceDescriptions)) {
            $count = min(count($serviceIcons), count($serviceTitles), count($serviceDescriptions));
            
            for ($i = 0; $i < $count; $i++) {
                if (!empty($serviceIcons[$i]) && !empty($serviceTitles[$i]) && !empty($serviceDescriptions[$i])) {
                    $services[] = [
                        'icon_name' => $serviceIcons[$i],
                        'service_title' => $serviceTitles[$i],
                        'service_description' => $serviceDescriptions[$i]
                    ];
                }
            }
        }
        
        $data = [
            'fld_title' => $this->request->getPost('title'),
            'fld_description' => $this->request->getPost('description'),
            'fld_image' => $image,
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->philosophyModel->updatePhilosophy($id, $data, $services, $multipleImages);
        
        return redirect()->to('/admin/investment-philosophy')->with('success', 'Investment philosophy updated successfully');
    }
    
    // Delete philosophy
    public function delete($id)
    {
        $philosophy = $this->philosophyModel->getPhilosophyById($id);
        
        if (empty($philosophy)) {
            return redirect()->to('/admin/investment-philosophy')->with('error', 'Investment philosophy not found');
        }
        
        $this->philosophyModel->deletePhilosophy($id);
        
        return redirect()->to('/admin/investment-philosophy')->with('success', 'Investment philosophy deleted successfully');
    }
    
    // Delete a specific image
    public function deleteImage($philosophyId, $imageId)
    {
        $imageModel = new \App\Models\InvestmentPhilosophyImageModel();
        $image = $imageModel->find($imageId);
        
        if ($image && $image['philosophy_id'] == $philosophyId) {
            // Delete file
            if (file_exists($image['image_path'])) {
                unlink($image['image_path']);
            }
            
            // Delete record
            $imageModel->delete($imageId);
            
            return $this->response->setJSON(['success' => true]);
        }
        
        return $this->response->setJSON(['success' => false]);
    }
}