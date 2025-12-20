<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubstackUpdateModel;
use App\Models\ProductModel;

class SubstackUpdates extends BaseController
{
    protected $substackUpdateModel;
    protected $productModel;

    public function __construct()
    {
        $this->substackUpdateModel = new SubstackUpdateModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'updates' => $this->substackUpdateModel->orderBy('fld_posted_at', 'DESC')->findAll(),
            'products' => $this->productModel->getAllActiveProducts()
        ];
        
        return view('admin/substack_updates/index', $data);
    }

    public function create()
    {
        $data = [
            'products' => $this->productModel->getAllActiveProducts()
        ];
        
        return view('admin/substack_updates/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'fld_title' => 'required',
            'fld_description' => 'required',
            'fld_url' => 'required|valid_url',
            'fld_product_ids' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        // Handle image upload
        $image = '';
        if ($file = $this->request->getFile('fld_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/substack_images', $newName);
                $image = 'uploads/substack_images/' . $newName;
            }
        }

        // Convert product IDs array to comma-separated string
        $productIds = $this->request->getPost('fld_product_ids');
        $productIdsString = is_array($productIds) ? implode(',', $productIds) : $productIds;

        $data = [
            'fld_product_ids' => $productIdsString,
            'fld_title' => $this->request->getPost('fld_title'),
            'fld_description' => $this->request->getPost('fld_description'),
            'fld_url' => $this->request->getPost('fld_url'),
            'fld_image' => $image,
            'fld_posted_at' => date('Y-m-d H:i:s'),
            'fld_status' => $this->request->getPost('fld_status') ? 1 : 0
        ];

        $this->substackUpdateModel->insert($data);

        return redirect()->to(base_url('admin/substack-updates'))->with('success', 'Substack update created successfully');
    }

    public function edit($id)
    {
        $update = $this->substackUpdateModel->find($id);
        
        if (!$update) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data = [
            'update' => $update,
            'products' => $this->productModel->getAllActiveProducts()
        ];
        
        return view('admin/substack_updates/edit', $data);
    }

    public function update($id)
    {
        $update = $this->substackUpdateModel->find($id);
        
        if (!$update) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'fld_title' => 'required',
            'fld_description' => 'required',
            'fld_url' => 'required|valid_url',
            'fld_product_ids' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        // Handle image upload
        $image = $update['fld_image'];
        if ($file = $this->request->getFile('fld_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Delete old image if exists
                if (!empty($update['fld_image']) && file_exists($update['fld_image'])) {
                    unlink($update['fld_image']);
                }
                
                $newName = $file->getRandomName();
                $file->move('uploads/substack_images', $newName);
                $image = 'uploads/substack_images/' . $newName;
            }
        }

        // Convert product IDs array to comma-separated string
        $productIds = $this->request->getPost('fld_product_ids');
        $productIdsString = is_array($productIds) ? implode(',', $productIds) : $productIds;

        $data = [
            'fld_product_ids' => $productIdsString,
            'fld_title' => $this->request->getPost('fld_title'),
            'fld_description' => $this->request->getPost('fld_description'),
            'fld_url' => $this->request->getPost('fld_url'),
            'fld_image' => $image,
            'fld_status' => $this->request->getPost('fld_status') ? 1 : 0
        ];

        $this->substackUpdateModel->update($id, $data);

        return redirect()->to(base_url('admin/substack-updates'))->with('success', 'Substack update updated successfully');
    }

    public function delete($id)
    {
        $update = $this->substackUpdateModel->find($id);
        
        if (!$update) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Delete image if exists
        if (!empty($update['fld_image']) && file_exists($update['fld_image'])) {
            unlink($update['fld_image']);
        }

        $this->substackUpdateModel->delete($id);

        return redirect()->to(base_url('admin/substack-updates'))->with('success', 'Substack update deleted successfully');
    }
}