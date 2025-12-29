<?php

namespace App\Models;

use CodeIgniter\Model;

class PdfAccessModel extends Model
{
    protected $table = 'pdf_access_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'pdf_type', 'pdf_filename', 'access_time', 'ip_address'
    ];
    protected $useTimestamps = false;
    
    /**
     * Log PDF access
     */
    public function logAccess($userId, $type, $filename)
    {
        $this->insert([
            'user_id' => $userId,
            'pdf_type' => $type,
            'pdf_filename' => $filename,
            'access_time' => date('Y-m-d H:i:s'),
            'ip_address' => service('request')->getIPAddress()
        ]);
    }
    
    /**
     * Get PDF access statistics
     */
    public function getAccessStats($userId = null, $startDate = null, $endDate = null)
    {
        $builder = $this->builder();
        
        if ($userId) {
            $builder->where('user_id', $userId);
        }
        
        if ($startDate) {
            $builder->where('access_time >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('access_time <=', $endDate);
        }
        
        return $builder->get()->getResultArray();
    }
}