<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AdminUserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            if (session()->get('isAdmin')) {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/');
            }
        }
        
        return view('auth/login');
    }
    
    public function login()
    {
        $session = session();
        $userModel = new UserModel();
        $adminModel = new AdminUserModel();
        
        // Check if this is an AJAX request
        if ($this->request->isAJAX()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            // First try to find as admin user
            $admin = $adminModel->getAdminByEmail($username);
            
            if ($admin) {
                // Check if admin is active
                if ($admin['fld_status'] == 0) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Your account is inactive. Please contact administrator.'
                    ]);
                }
                
                // Verify password (using MD5 as per requirement)
                if (md5($password) === $admin['fld_password']) {
                    // Update last login
                    $adminModel->updateLastLogin($admin['id']);
                    
                    // Set session data for admin
                    $sessionData = [
                        'adminId' => $admin['id'],
                        'adminEmail' => $admin['fld_email'],
                        'adminName' => $admin['fld_full_name'],
                        'adminRole' => $admin['fld_role'],
                        'isLoggedIn' => TRUE,
                        'isAdmin' => TRUE
                    ];
                    
                    $session->set($sessionData);
                    
                    return $this->response->setJSON([
                        'success' => true,
                        'redirect' => base_url('admin/dashboard')
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Invalid password'
                    ]);
                }
            }
            
            // If not found as admin, try as regular user
            $user = $userModel->getUserByEmailOrMobile($username);
            
            if ($user) {
                // Check if user is active
                if ($user['fld_status'] == 0) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Your account is inactive. Please contact administrator.'
                    ]);
                }
                
                // Verify password (using MD5 as per requirement)
                if (md5($password) === $user['fld_password']) {
                    // Set session data for front user
                    $sessionData = [
                        'userId' => $user['id'],
                        'userEmail' => $user['fld_email'],
                        'userMobile' => $user['fld_mobile'],
                        'userName' => $user['fld_full_name'],
                        'userRole' => $user['fld_role'],
                        'isLoggedIn' => TRUE,
                        'isAdmin' => FALSE
                    ];
                    
                    $session->set($sessionData);
                    
                    return $this->response->setJSON([
                        'success' => true,
                        'redirect' => base_url('/')
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Invalid password'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }
        } else {
            // Handle non-AJAX form submission
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            // First try to find as admin user
            $admin = $adminModel->getAdminByEmail($username);
            
            if ($admin) {
                // Check if admin is active
                if ($admin['fld_status'] == 0) {
                    $session->setFlashdata('error', 'Your account is inactive. Please contact administrator.');
                    return redirect()->to('/auth')->withInput();
                }
                
                // Verify password
                if (md5($password) === $admin['fld_password']) {
                    // Update last login
                    $adminModel->updateLastLogin($admin['id']);
                    
                    // Set session data for admin
                    $sessionData = [
                        'adminId' => $admin['id'],
                        'adminEmail' => $admin['fld_email'],
                        'adminName' => $admin['fld_full_name'],
                        'adminRole' => $admin['fld_role'],
                        'isLoggedIn' => TRUE,
                        'isAdmin' => TRUE
                    ];
                    
                    $session->set($sessionData);
                    
                    return redirect()->to('/admin/dashboard');
                } else {
                    $session->setFlashdata('error', 'Invalid password');
                    return redirect()->to('/auth')->withInput();
                }
            }
            
            // If not found as admin, try as regular user
            $user = $userModel->getUserByEmailOrMobile($username);
            
            if ($user) {
                // Check if user is active
                if ($user['fld_status'] == 0) {
                    $session->setFlashdata('error', 'Your account is inactive. Please contact administrator.');
                    return redirect()->to('/auth')->withInput();
                }
                
                // Verify password
                if (md5($password) === $user['fld_password']) {
                    // Set session data for front user
                    $sessionData = [
                        'userId' => $user['id'],
                        'userEmail' => $user['fld_email'],
                        'userMobile' => $user['fld_mobile'],
                        'userName' => $user['fld_full_name'],
                        'userRole' => $user['fld_role'],
                        'isLoggedIn' => TRUE,
                        'isAdmin' => FALSE
                    ];
                    
                    $session->set($sessionData);
                    
                    return redirect()->to('/');
                } else {
                    $session->setFlashdata('error', 'Invalid password');
                    return redirect()->to('/auth')->withInput();
                }
            } else {
                $session->setFlashdata('error', 'User not found');
                return redirect()->to('/auth')->withInput();
            }
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth');
    }
}