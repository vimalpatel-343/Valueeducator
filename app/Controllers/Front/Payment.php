<?php
namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\UserSubscriptionModel;
use App\Models\PaymentModel;
use Razorpay\Api\Api;

class Payment extends BaseController
{
    protected $userModel;
    protected $productModel;
    protected $userSubscriptionModel;
    protected $paymentModel;
    protected $razorpayApi;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->userSubscriptionModel = new UserSubscriptionModel();
        $this->paymentModel = new PaymentModel();
        
        // Initialize RazorPay API
        $this->razorpayApi = new Api(
            getenv('RAZORPAY_KEY_ID'), 
            getenv('RAZORPAY_KEY_SECRET')
        );
    }

    // Create order for RazorPay checkout
    public function createOrder()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please login to continue',
                'redirect' => base_url('login')
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $amount = $this->request->getPost('amount');
        $subscriptionType = $this->request->getPost('subscription_type');
        
        // Validate product
        $product = $this->productModel->find($productId);
        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid product'
            ]);
        }

        // Convert amount to paise (RazorPay expects amount in smallest currency unit)
        $amountInPaise = (int)($amount * 100);

        try {
            // Create RazorPay order
            $orderData = [
                'receipt'         => 'receipt_' . time(),
                'amount'          => $amountInPaise,
                'currency'        => 'INR',
                'payment_capture'  => 1 // Auto capture
            ];

            $razorpayOrder = $this->razorpayApi->order->create($orderData);

            // Save order details to database
            $paymentData = [
                'user_id'       => session()->get('userId'),
                'product_id'    => $productId,
                'order_id'      => $razorpayOrder['id'],
                'amount'        => $amount,
                'status'        => 'created'
            ];

            $paymentId = $this->paymentModel->insert($paymentData);

            return $this->response->setJSON([
                'status'    => 'success',
                'order_id'  => $razorpayOrder['id'],
                'amount'    => $amountInPaise,
                'key_id'    => getenv('RAZORPAY_KEY_ID'),
                'product_name' => $product['fld_title'],
                'description' => $subscriptionType . ' subscription',
                'payment_id' => $paymentId
            ]);

        } catch (\Exception $e) {
            
            $this->paymentModel->update($paymentId, [
                'status' => 'failed',
                'error_code' => 'VERIFICATION_ERROR',
                'error_description' => $e->getMessage()
            ]);

            // Check for specific error types
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'international_transaction_not_allowed') !== false) {
                $errorMessage = 'International cards are not supported. Please use a domestic test card for testing.';
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errorMessage
            ]);
        }
    }

    // Verify payment and create subscription
    public function verifyPayment()
    {
        $razorpayPaymentId = $this->request->getPost('razorpay_payment_id');
        $razorpayOrderId = $this->request->getPost('razorpay_order_id');
        $razorpaySignature = $this->request->getPost('razorpay_signature');
        $paymentId = $this->request->getPost('payment_id');

        // Verify signature
        $generatedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, getenv('RAZORPAY_KEY_SECRET'));

        if ($generatedSignature !== $razorpaySignature) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Payment verification failed'
            ]);
        }

        try {
            // Fetch payment details from RazorPay
            $payment = $this->razorpayApi->payment->fetch($razorpayPaymentId);

            // Update payment record
            $paymentData = [
                'payment_id'    => $razorpayPaymentId,
                'signature'     => $razorpaySignature,
                'status'        => $payment->status,
                'payment_method'=> $payment->method,
                'bank'          => $payment->bank ?? null,
                'wallet'        => $payment->wallet ?? null,
                'vpa'           => $payment->vpa ?? null,
                'email'         => $payment->email,
                'contact'       => $payment->contact
            ];

            $this->paymentModel->update($paymentId, $paymentData);

            // If payment is successful, create subscription
            if ($payment->status === 'captured') {
                $paymentRecord = $this->paymentModel->find($paymentId);
                $product = $this->productModel->find($paymentRecord['product_id']);
                
                // Calculate subscription dates
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime('+12 months')); // For yearly subscription
                
                // Create subscription
                $subscriptionData = [
                    'user_id'           => session()->get('userId'),
                    'product_id'        => $paymentRecord['product_id'],
                    'subscription_type' => 'yearly',
                    'amount'            => $paymentRecord['amount'],
                    'start_date'        => $startDate,
                    'end_date'          => $endDate,
                    'status'            => 1
                ];

                $subscriptionId = $this->userSubscriptionModel->insert($subscriptionData);

                // Update payment record with subscription ID
                $this->paymentModel->update($paymentId, ['subscription_id' => $subscriptionId]);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Payment successful and subscription activated'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Payment not captured'
                ]);
            }

        } catch (\Exception $e) {
            // Update payment record with error details
            $this->paymentModel->update($paymentId, [
                'status' => 'failed',
                'error_code' => 'VERIFICATION_ERROR',
                'error_description' => $e->getMessage()
            ]);

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // Payment success page
    public function success()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $data['meta'] = [
            'title' => 'Payment Successful - Value Educator',
            'description' => 'Your payment has been processed successfully.'
        ];

        return view('front/payment/success', $data);
    }

    // Payment failed page
    public function failed()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $data['meta'] = [
            'title' => 'Payment Failed - Value Educator',
            'description' => 'There was an issue processing your payment.'
        ];

        return view('front/payment/failed', $data);
    }
}