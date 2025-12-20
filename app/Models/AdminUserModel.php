<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table = 've_admin_users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_email', 'fld_password', 'fld_full_name', 'fld_role', 'fld_status', 'fld_last_login'];
    
    // Function to get admin user by email
    public function getAdminByEmail($email)
    {
        return $this->where('fld_email', $email)->first();
    }
    
    // Update last login time
    public function updateLastLogin($id)
    {
        return $this->update($id, ['fld_last_login' => date('Y-m-d H:i:s')]);
    }
}