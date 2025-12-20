<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplaintDataModel;

class ComplaintData extends BaseController
{
    protected $complaintDataModel;
    
    public function __construct()
    {
        $this->complaintDataModel = new ComplaintDataModel();
        helper('text');
    }
    
    // List all complaint data
    public function index()
    {
        $data['complaintData'] = $this->complaintDataModel->findAll();
        $data['title'] = 'Complaint Data';
        
        return view('admin/complaint_data/index', $data);
    }
    
    // Show form to create new complaint data
    public function create()
    {
        $data['title'] = 'Create Complaint Data';
        
        return view('admin/complaint_data/create', $data);
    }
    
    // Store new complaint data
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'table_heading' => 'required|min_length[3]|max_length[255]',
            'table_data' => 'required',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Process table data (convert to JSON)
        $tableData = $this->request->getPost('table_data');
        
        $data = [
            'fld_table_heading' => $this->request->getPost('table_heading'),
            'fld_table_data' => json_encode($tableData),
            'fld_table_footer' => $this->request->getPost('table_footer'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->complaintDataModel->createComplaintData($data);
        
        return redirect()->to('/admin/complaint-data')->with('success', 'Complaint data created successfully');
    }
    
    // Show form to edit complaint data
    public function edit($id)
    {
        $data['complaint'] = $this->complaintDataModel->getComplaintDataById($id);
        
        if (empty($data['complaint'])) {
            return redirect()->to('/admin/complaint-data')->with('error', 'Complaint data not found');
        }
        
        // Decode JSON data for editing
        $data['complaint']['fld_table_data'] = json_decode($data['complaint']['fld_table_data'], true);
        
        $data['title'] = 'Edit Complaint Data';
        
        return view('admin/complaint_data/edit', $data);
    }
    
    // Update complaint data
    public function update($id)
    {
        $complaint = $this->complaintDataModel->getComplaintDataById($id);
        
        if (empty($complaint)) {
            return redirect()->to('/admin/complaint-data')->with('error', 'Complaint data not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'table_heading' => 'required|min_length[3]|max_length[255]',
            'table_data' => 'required',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Process table data (convert to JSON)
        $tableData = $this->request->getPost('table_data');
        
        $data = [
            'fld_table_heading' => $this->request->getPost('table_heading'),
            'fld_table_data' => json_encode($tableData),
            'fld_table_footer' => $this->request->getPost('table_footer'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->complaintDataModel->updateComplaintData($id, $data);
        
        return redirect()->to('/admin/complaint-data')->with('success', 'Complaint data updated successfully');
    }
    
    // Delete complaint data
    public function delete($id)
    {
        $complaint = $this->complaintDataModel->getComplaintDataById($id);
        
        if (empty($complaint)) {
            return redirect()->to('/admin/complaint-data')->with('error', 'Complaint data not found');
        }
        
        $this->complaintDataModel->deleteComplaintData($id);
        
        return redirect()->to('/admin/complaint-data')->with('success', 'Complaint data deleted successfully');
    }
}