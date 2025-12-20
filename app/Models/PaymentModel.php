<?php
namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 've_payments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id',
        'subscription_id',
        'product_id',
        'payment_id',
        'order_id',
        'signature',
        'amount',
        'status',
        'payment_method',
        'bank',
        'wallet',
        'vpa',
        'email',
        'contact',
        'error_code',
        'error_description'
    ];

    // Get payment by order ID
    public function getPaymentByOrderId($orderId)
    {
        return $this->where('order_id', $orderId)->first();
    }

    // Get payment by payment ID
    public function getPaymentByPaymentId($paymentId)
    {
        return $this->where('payment_id', $paymentId)->first();
    }

    public function getUserOrders($userId)
    {
        $this->select('ve_payments.*, ve_products.fld_title as product_name');
        $this->join('ve_products', 've_products.id = ve_payments.product_id');
        $this->where('ve_payments.user_id', $userId);
        $this->where('ve_payments.status', 'captured');
        $this->orderBy('ve_payments.created_at', 'DESC');
        return $this->findAll();
    }
}