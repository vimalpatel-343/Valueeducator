<?php
namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use App\Models\UserSubscriptionModel;
use App\Models\UserModel;

class UserAccount extends BaseController
{
    protected $paymentModel;
    protected $userSubscriptionModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->userSubscriptionModel = new UserSubscriptionModel();
    }

    // Get user orders
    public function getOrders()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }

        $userId = session()->get('userId');
        $orders = $this->paymentModel->getUserOrders($userId);

        return $this->response->setJSON([
            'status' => 'success',
            'orders' => $orders
        ]);
    }

    // Get user subscriptions
    public function getSubscriptions()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }

        $userId = session()->get('userId');
        $subscriptions = $this->userSubscriptionModel->getUserSubscriptions($userId);

        return $this->response->setJSON([
            'status' => 'success',
            'subscriptions' => $subscriptions
        ]);
    }

    public function checkKycStatus()
    {
        $userId = session()->get('userId');
        if (!$userId) {
            return $this->response->setJSON(['kyc_status' => 0]);
        }
        
        $userModel = new UserModel();
        $user = $userModel->find($userId);
        
        return $this->response->setJSON(['kyc_status' => $user['fld_kyc_status'] ?? 0]);
    }    
}