<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;

class AdminUserManagement extends BaseController
{
    protected $adminUserModel;
    
    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
        helper('text');
    }
    
    // List all admin users
    public function index()
    {
        $data['adminUsers'] = $this->adminUserModel->findAll();
        $data['title'] = 'Admin User Management';
        
        return view('admin/admin_user_management/index', $data);
    }
    
    // Show form to create new admin user
    public function create()
    {
        $data['title'] = 'Create Admin User';
        
        return view('admin/admin_user_management/create', $data);
    }
    
    // Store new admin user
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'email' => 'required|valid_email|is_unique[ve_admin_users.fld_email]',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'role' => 'required|in_list[admin,superadmin]',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'fld_email' => $this->request->getPost('email'),
            'fld_password' => md5($this->request->getPost('password')),
            'fld_full_name' => $this->request->getPost('full_name'),
            'fld_role' => $this->request->getPost('role'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->adminUserModel->insert($data);
        
        return redirect()->to('/admin/admin-users')->with('success', 'Admin user created successfully');
    }
    
    // Show form to edit admin user
    public function edit($id)
    {
        $data['adminUser'] = $this->adminUserModel->find($id);
        
        if (empty($data['adminUser'])) {
            return redirect()->to('/admin/admin-users')->with('error', 'Admin user not found');
        }
        
        $data['title'] = 'Edit Admin User';
        
        return view('admin/admin_user_management/edit', $data);
    }
    
    // Update admin user
    public function update($id)
    {
        $adminUser = $this->adminUserModel->find($id);
        
        if (empty($adminUser)) {
            return redirect()->to('/admin/admin-users')->with('error', 'Admin user not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'email' => 'required|valid_email',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'role' => 'required|in_list[admin,superadmin]',
            'status' => 'required|in_list[0,1]'
        ];
        
        // Only validate password if it's provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'matches[password]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'fld_email' => $this->request->getPost('email'),
            'fld_full_name' => $this->request->getPost('full_name'),
            'fld_role' => $this->request->getPost('role'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        // Update password only if provided
        if ($this->request->getPost('password')) {
            $data['fld_password'] = md5($this->request->getPost('password'));
        }
        
        $this->adminUserModel->update($id, $data);
        
        return redirect()->to('/admin/admin-users')->with('success', 'Admin user updated successfully');
    }
    
    // Delete admin user
    public function delete($id)
    {
        $adminUser = $this->adminUserModel->find($id);
        
        if (empty($adminUser)) {
            return redirect()->to('/admin/admin-users')->with('error', 'Admin user not found');
        }
        
        // Prevent deletion of superadmin
        if ($adminUser['fld_role'] === 'superadmin') {
            return redirect()->to('/admin/admin-users')->with('error', 'Cannot delete superadmin users');
        }
        
        $this->adminUserModel->delete($id);
        
        return redirect()->to('/admin/admin-users')->with('success', 'Admin user deleted successfully');
    }
}