<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 've_users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_email', 'fld_mobile', 'fld_password', 'fld_full_name', 'fld_address', 'fld_status', 'fld_role', 'fld_kyc_status', 'fld_kyc_start_date', 'fld_kyc_end_date'];
    
    // Function to get user by email or mobile
    public function getUserByEmailOrMobile($identity)
    {
        return $this->where('fld_email', $identity)
                    ->orWhere('fld_mobile', $identity)
                    ->first();
    }

    public function getUserById($userId)
    {
        return $this->find($userId);
    }

    // Function to check KYC status
    public function hasValidKyc($userId)
    {
        $user = $this->find($userId);
        
        if (!$user) {
            return false;
        }
        
        $currentDate = date('Y-m-d');
        
        // Check if KYC is completed and still valid
        if ($user['fld_kyc_status'] == 1 && 
            $user['fld_kyc_start_date'] <= $currentDate && 
            $user['fld_kyc_end_date'] >= $currentDate) {
            return true;
        }
        
        return false;
    }
}