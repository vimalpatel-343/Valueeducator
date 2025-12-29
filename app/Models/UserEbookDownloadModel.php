<?php

namespace App\Models;

use CodeIgniter\Model;

class UserEbookDownloadModel extends Model
{
    protected $table = 've_user_ebook_downloads';
    protected $primaryKey = 'fld_id';
    protected $allowedFields = ['fld_user_id', 'fld_download_count', 'fld_last_download_date', 'fld_created_at', 'fld_updated_at'];
    protected $returnType = 'array';
    
    // Check if user has downloaded the ebook
    public function hasUserDownloadedEbook($userId)
    {
        $count = $this->where('fld_user_id', $userId)->countAllResults();
        return $count > 0;
    }
    
    // Get download count for a user
    public function getDownloadCount($userId)
    {
        return $this->where('fld_user_id', $userId)->countAllResults();
    }
    
    // Get the last download date for a user
    public function getLastDownloadDate($userId)
    {
        $result = $this->where('fld_user_id', $userId)
                      ->orderBy('fld_created_at', 'DESC')
                      ->first();
        
        return $result ? $result['fld_created_at'] : null;
    }
    
    // Get all download records for a user
    public function getUserDownloads($userId)
    {
        return $this->where('fld_user_id', $userId)
                    ->orderBy('fld_created_at', 'DESC')
                    ->findAll();
    }
}