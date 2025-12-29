<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserSubscriptionModel;
use App\Models\ProductModel;
use App\Models\UserLoginModel;
use App\Models\UserEbookDownloadModel;
use App\Helpers\EmailHelper;

class UserManagement extends BaseController
{
    protected $userModel;
    protected $userSubscriptionModel;
    protected $productModel;
    protected $userEbookDownloadModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userSubscriptionModel = new UserSubscriptionModel();
        $this->productModel = new ProductModel();
        $this->userLoginModel = new UserLoginModel();
        $this->userEbookDownloadModel = new UserEbookDownloadModel();
        helper('text');
    }
    
    // Helper function to generate pagination URLs
    protected function generatePageUrl($page)
    {
        $params = $this->request->getGet();
        $params['page'] = $page;
        
        return base_url('admin/users') . '?' . http_build_query($params);
    }
    
    // List all users with pagination and filtering
    public function index()
    {
        // Get filter parameters
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $subscription_filter = $this->request->getGet('subscription');
        $perPage = $this->request->getGet('per_page') ?? 50;
        
        // Validate per_page options
        $perPageOptions = [10, 20, 50, 100];
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 50;
        }
        
        // Get overall statistics from all users (without filters)
        $allUsers = $this->userModel->where('fld_role !=', 'superadmin')->findAll();
        
        // Calculate statistics
        $stats = [
            'totalUsers' => count($allUsers),
            'activeUsers' => 0,
            'subscribedUsers' => 0,
            'totalRevenue' => 0
        ];
        
        // Get all active subscriptions for statistics
        $allSubscriptions = $this->userSubscriptionModel->where('status', 1)->findAll();
        
        foreach ($allSubscriptions as $subscription) {
            $stats['totalRevenue'] += $subscription['amount'];
        }
        
        // Get unique subscribed users
        $subscribedUserIds = [];
        foreach ($allSubscriptions as $subscription) {
            $subscribedUserIds[] = $subscription['user_id'];
        }
        $stats['subscribedUsers'] = count(array_unique($subscribedUserIds));
        
        // Count active users
        foreach ($allUsers as $user) {
            if ($user['fld_status'] == 1) {
                $stats['activeUsers']++;
            }
        }
        
        // Get product details for subscription columns
        $products = $this->productModel->whereIn('fld_slug', ['emerging-titans', 'tiny-titans'])->findAll();
        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product['id']] = $product;
        }
        
        // Start building query for filtered users
        $builder = $this->userModel->builder();
        
        // Apply filters
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('fld_full_name', $search)
                    ->orLike('fld_email', $search)
                    ->orLike('fld_mobile', $search)
                    ->groupEnd();
        }
        
        if ($status === '0' || $status === '1') {
            $builder->where('fld_status', (int)$status);
        }
        
        // Apply subscription filter
        if ($subscription_filter === 'subscribed') {
            $builder->whereIn('id', $subscribedUserIds);
        } elseif ($subscription_filter === 'not_subscribed') {
            $builder->whereNotIn('id', $subscribedUserIds);
        }
        
        // Exclude superadmin
        $builder->where('fld_role !=', 'superadmin');
        
        // Pagination
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $perPage;
        
        // Get total count for pagination
        $total = $builder->countAllResults(false);
        
        // Get users with pagination
        $users = $builder->select('ve_users.*')
                        ->orderBy('id', 'DESC')
                        ->limit($perPage, $offset)
                        ->get()
                        ->getResultArray();
        
        // Get user ebook download information
        $ebookDownloads = $this->userEbookDownloadModel
            ->select('fld_user_id, COUNT(*) as download_count, MAX(fld_created_at) as last_download_date')
            ->groupBy('fld_user_id')
            ->findAll();

        $downloadData = [];
        foreach ($ebookDownloads as $download) {
            $downloadData[$download['fld_user_id']] = [
                'count' => $download['download_count'],
                'last_download_date' => $download['last_download_date']
            ];
        }

        // Get subscription details and login history for each user
        foreach ($users as &$user) {
            // Get all subscriptions for this user
            $subscriptions = $this->userSubscriptionModel
                ->where('user_id', $user['id'])
                ->findAll();
            
            // Organize subscriptions by product
            $user['productSubscriptions'] = [];
            foreach ($subscriptions as $subscription) {
                if (isset($productMap[$subscription['product_id']])) {
                    $productSlug = $productMap[$subscription['product_id']]['fld_slug'];
                    $user['productSubscriptions'][$productSlug] = $subscription;
                }
            }
            
            // Calculate total subscription amount
            $totalAmount = 0;
            foreach ($subscriptions as $subscription) {
                $totalAmount += $subscription['amount'];
            }
            $user['total_subscription_amount'] = $totalAmount;
            
            // Get subscription status
            $user['has_active_subscription'] = !empty($subscriptions);
            
            // Get last login time
            $user['last_login'] = $this->userLoginModel->getLastLoginTime($user['id']);
            
            // Get login history
            $user['login_history'] = $this->userLoginModel->getUserLoginHistory($user['id'], 3);

            // Get ebook download status
            $user['has_downloaded_ebook'] = isset($downloadData[$user['id']]);
            $user['ebook_download_count'] = $downloadData[$user['id']]['count'] ?? 0;
            $user['last_ebook_download_date'] = $downloadData[$user['id']]['last_download_date'] ?? null;
        }
        
        // Calculate pagination data
        $totalPages = ceil($total / $perPage);
        
        // Generate pagination URLs
        $paginationUrls = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $paginationUrls[$i] = $this->generatePageUrl($i);
        }
        
        $data = [
            'users' => $users,
            'stats' => $stats,
            'productMap' => $productMap,
            'perPage' => $perPage,
            'perPageOptions' => $perPageOptions,
            'title' => 'User Management',
            'pagination' => [
                'total' => $total,
                'perPage' => $perPage,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'urls' => $paginationUrls,
                'prevUrl' => $page > 1 ? $this->generatePageUrl($page - 1) : null,
                'nextUrl' => $page < $totalPages ? $this->generatePageUrl($page + 1) : null
            ],
            'filters' => [
                'search' => $search,
                'status' => $status,
                'subscription' => $subscription_filter
            ]
        ];
        
        return view('admin/user_management/index', $data);
    }
    
    // Show form to create new user
    public function create()
    {
        $data['title'] = 'Create User';
        
        return view('admin/user_management/create', $data);
    }
    
    // Store new user
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'email' => 'required|valid_email|is_unique[ve_users.fld_email]',
            'mobile' => 'required|min_length[10]|max_length[20]',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'password' => 'required|min_length[6]',
            'status' => 'required|in_list[0,1]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'fld_email' => $this->request->getPost('email'),
            'fld_mobile' => $this->request->getPost('mobile'),
            'fld_country_code' => $this->request->getPost('country_code'),
            'fld_full_name' => $this->request->getPost('full_name'),
            'fld_address' => $this->request->getPost('address'),
            'fld_password' => md5($this->request->getPost('password')),
            'fld_status' => $this->request->getPost('status')
        ];
        
        $this->userModel->insert($data);
        
        return redirect()->to('/admin/users')->with('success', 'User created successfully');
    }
    
    // Show form to edit user
    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        
        if (empty($data['user'])) {
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }
        
        // Get all products for subscription dropdown
        $data['products'] = $this->productModel->findAll();
        
        // Get user subscriptions
        $data['subscriptions'] = $this->userSubscriptionModel
            ->select('user_subscriptions.*, p.fld_title')
            ->join('ve_products AS p', 'p.id = user_subscriptions.product_id', 'left')
            ->where('user_subscriptions.user_id', $id)
            ->findAll();
        
        $data['title'] = 'Edit User';
        
        return view('admin/user_management/edit', $data);
    }
    
    // Update user
    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (empty($user)) {
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }
        
        $validation = \Config\Services::validation();
        
        $rules = [
            'email' => 'required|valid_email',
            'mobile' => 'required|min_length[10]|max_length[20]',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'status' => 'required|in_list[0,1]'
        ];
        
        // Only validate password if it's provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $data = [
            'fld_email' => $this->request->getPost('email'),
            'fld_mobile' => $this->request->getPost('mobile'),
            'fld_full_name' => $this->request->getPost('full_name'),
            'fld_address' => $this->request->getPost('address'),
            'fld_status' => $this->request->getPost('status')
        ];
        
        // Update password only if provided
        if ($this->request->getPost('password')) {
            $data['fld_password'] = md5($this->request->getPost('password'));
        }
        
        $this->userModel->update($id, $data);
        
        return redirect()->to('/admin/users')->with('success', 'User updated successfully');
    }
    
    // Delete user
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (empty($user)) {
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }
        
        // Prevent deletion of admin users
        if ($user['fld_role'] === 'admin' || $user['fld_role'] === 'superadmin') {
            return redirect()->to('/admin/users')->with('error', 'Cannot delete admin users');
        }
        
        $this->userModel->delete($id);
        
        return redirect()->to('/admin/users')->with('success', 'User deleted successfully');
    }
    
    // View user subscriptions
    public function viewSubscriptions($userId)
    {
        $user = $this->userModel->find($userId);
        
        if (empty($user)) {
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }
        
        $subscriptions = $this->userSubscriptionModel->getUserSubscriptions($userId);
        
        // Get product details for each subscription
        foreach ($subscriptions as &$subscription) {
            $product = $this->productModel->find($subscription['product_id']);
            $subscription['product'] = $product;
        }
        
        $data['user'] = $user;
        $data['subscriptions'] = $subscriptions;
        $data['title'] = 'User Subscriptions - ' . $user['fld_full_name'];
        
        return view('admin/user_management/subscriptions', $data);
    }

    // Get user login history via AJAX
    public function getLoginHistory($userId)
    {
        $loginHistory = $this->userLoginModel->getUserLoginHistory($userId, 20);
        
        return $this->response->setJSON([
            'success' => true,
            'loginHistory' => $loginHistory
        ]);
    }

    // Update KYC status
    public function updateKycStatus()
    {
        $userId = $this->request->getPost('user_id');
        $kycStatus = $this->request->getPost('kyc_status');
        $kycStartDate = $this->request->getPost('kyc_start_date');
        $kycEndDate = $this->request->getPost('kyc_end_date');

        $user = $this->userModel->find($userId);
        
        if (empty($user)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
        
        if ((int) $kycStatus === 0) {
            $data = [
                'fld_kyc_status'      => 0,
                'fld_kyc_start_date' => null,
                'fld_kyc_end_date'   => null,
            ];
        } else {
            $data = [
                'fld_kyc_status'      => $kycStatus,
                'fld_kyc_start_date' => (isset($kycStartDate) && !empty($kycStartDate))?$kycStartDate:date('Y-m-d'),
                'fld_kyc_end_date'   => (isset($kycEndDate) && !empty($kycEndDate))?$kycEndDate:date('Y-m-d', strtotime('+1 year')),
            ];
        }

        $this->userModel->update($userId, $data);
        
        // If KYC is marked as done, send email notification
        if ($kycStatus == 1) {
            $emailSent = EmailHelper::sendKycCompletionEmail($user['fld_email'], $user['fld_full_name']);
            
            if (!$emailSent) {
                // Log the error but don't fail the update
                log_message('error', 'Failed to send KYC completion email to user ID: ' . $userId);
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'KYC status updated successfully'
        ]);
    }

    // Add a new subscription for a user
    public function addSubscription()
    {
        $userId = $this->request->getPost('user_id');
        $productId = $this->request->getPost('product_id');
        $subscriptionType = $this->request->getPost('subscription_type');
        $amount = $this->request->getPost('amount');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        
        $data = [
            'user_id' => $userId,
            'product_id' => $productId,
            'subscription_type' => $subscriptionType,
            'amount' => $amount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 1, // Active by default
        ];
        
        $this->userSubscriptionModel->insert($data);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Subscription added successfully'
        ]);
    }
    
    // Update an existing subscription
    public function updateSubscription()
    {
        $subscriptionId = $this->request->getPost('subscription_id');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $status = $this->request->getPost('status');
        
        $data = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
        ];
        
        $this->userSubscriptionModel->update($subscriptionId, $data);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Subscription updated successfully'
        ]);
    }

    public function getProductPrice($productId)
    {
        $product = $this->productModel->find($productId);
        
        if ($product) {
            return $this->response->setJSON([
                'success' => true,
                'price' => $product['fld_pricing']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
    }
    
    public function deleteSubscription()
    {
        $subscriptionId = $this->request->getPost('subscription_id');
        
        if (!$subscriptionId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Subscription ID is required']);
        }
        
        // Check if subscription exists
        $subscription = $this->userSubscriptionModel->find($subscriptionId);
        
        if (!$subscription) {
            return $this->response->setJSON(['success' => false, 'message' => 'Subscription not found']);
        }
        
        // Delete the subscription
        if ($this->userSubscriptionModel->delete($subscriptionId)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Subscription deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete subscription']);
        }
    }

    // Get user ebook download history via AJAX
    public function getEbookDownloadHistory($userId)
    {
        $downloadHistory = $this->userEbookDownloadModel->getUserDownloads($userId);
        
        return $this->response->setJSON([
            'success' => true,
            'downloadHistory' => $downloadHistory
        ]);
    }
}