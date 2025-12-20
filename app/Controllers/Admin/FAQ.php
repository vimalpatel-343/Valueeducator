<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FAQModel;
use App\Models\ProductModel;

class FAQ extends BaseController
{
    protected $faqModel;
    protected $productModel;
    
    public function __construct()
    {
        $this->faqModel = new FAQModel();
        $this->productModel = new ProductModel();
        helper('text');
    }
    
    // List all FAQs
    public function index()
    {
        $data['faqs'] = $this->faqModel->select('ve_faqs.*, ve_products.fld_title as product_title')
                                    ->join('ve_products', 've_products.id = ve_faqs.fld_product_id', 'left')
                                    ->findAll();
        $data['title'] = 'FAQs';
        
        return view('admin/faq/index', $data);
    }
    
    // Show form to create new FAQ
    public function create()
    {
        $data['products'] = $this->productModel->getActiveProducts();
        $data['title'] = 'Create FAQ';
        
        return view('admin/faq/create', $data);
    }
    
    // Store new FAQ
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'question' => 'required|min_length[5]|max_length[255]',
            'answer' => 'required|min_length[10]',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'fld_product_id' => $this->request->getPost('product_id') ? $this->request->getPost('product_id') : null,
            'fld_question' => $this->request->getPost('question'),
            'fld_answer' => $this->request->getPost('answer'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->faqModel->createFAQ($data);
        
        return redirect()->to('/admin/faqs')->with('success', 'FAQ created successfully');
    }
    
    // Show form to edit FAQ
    public function edit($id)
    {
        $data['faq'] = $this->faqModel->getFAQById($id);
        $data['products'] = $this->productModel->getActiveProducts();
        
        if (empty($data['faq'])) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found');
        }
        
        $data['title'] = 'Edit FAQ';
        
        return view('admin/faq/edit', $data);
    }
    
    // Update FAQ
    public function update($id)
    {
        $faq = $this->faqModel->getFAQById($id);
        
        if (empty($faq)) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'question' => 'required|min_length[5]|max_length[255]',
            'answer' => 'required|min_length[10]',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'fld_product_id' => $this->request->getPost('product_id') ? $this->request->getPost('product_id') : null,
            'fld_question' => $this->request->getPost('question'),
            'fld_answer' => $this->request->getPost('answer'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->faqModel->updateFAQ($id, $data);
        
        return redirect()->to('/admin/faqs')->with('success', 'FAQ updated successfully');
    }
    
    // Delete FAQ
    public function delete($id)
    {
        $faq = $this->faqModel->getFAQById($id);
        
        if (empty($faq)) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found');
        }
        
        $this->faqModel->deleteFAQ($id);
        
        return redirect()->to('/admin/faqs')->with('success', 'FAQ deleted successfully');
    }
}