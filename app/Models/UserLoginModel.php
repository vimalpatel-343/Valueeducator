<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLoginModel extends Model
{
    protected $table = 've_user_logins';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_user_id', 'fld_ip_address', 'fld_user_agent', 'fld_login_time'];
    
    // Get user login history
    public function getUserLoginHistory($userId, $limit = 5)
    {
        return $this->where('fld_user_id', $userId)
                    ->orderBy('fld_login_time', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    // Get last login time
    public function getLastLoginTime($userId)
    {
        $login = $this->where('fld_user_id', $userId)
                     ->orderBy('fld_login_time', 'DESC')
                     ->first();
        
        return $login ? $login['fld_login_time'] : null;
    }
}