<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplaintDataModel extends Model
{
    protected $table = 've_complaint_data';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_table_heading', 'fld_table_data', 'fld_table_footer', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get all active complaint data
    public function getActiveComplaintData()
    {
        return $this->where('fld_status', 1)->findAll();
    }
    
    // Get complaint data by ID
    public function getComplaintDataById($id)
    {
        return $this->find($id);
    }
    
    // Create new complaint data
    public function createComplaintData($data)
    {
        return $this->insert($data);
    }
    
    // Update complaint data
    public function updateComplaintData($id, $data)
    {
        return $this->update($id, $data);
    }
    
    // Delete complaint data
    public function deleteComplaintData($id)
    {
        return $this->delete($id);
    }

    public function getAllActiveTables()
    {
        try {
            return $this->where('fld_status', 1)
                        ->orderBy('id', 'ASC')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error in ComplaintDataModel::getAllActiveTables: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getTableById($id)
    {
        try {
            return $this->where('id', $id)
                        ->where('fld_status', 1)
                        ->first();
        } catch (\Exception $e) {
            log_message('error', 'Error in ComplaintDataModel::getTableById: ' . $e->getMessage());
            return null;
        }
    }
    
    public function decodeTableData($jsonData)
    {
        $data = json_decode($jsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'JSON decode error: ' . json_last_error_msg());
            return [];
        }
        return $data;
    }
}