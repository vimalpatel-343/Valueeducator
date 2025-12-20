<?php

namespace App\Models;

use CodeIgniter\Model;

class FAQModel extends Model
{
    protected $table = 've_faqs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_product_id', 'fld_question', 'fld_answer', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get all active FAQs
    public function getActiveFAQs()
    {
        return $this->where('fld_status', 1)->findAll();
    }
    
    // Get FAQ by ID
    public function getFAQById($id)
    {
        return $this->find($id);
    }
    
    // Create new FAQ
    public function createFAQ($data)
    {
        return $this->insert($data);
    }
    
    // Update FAQ
    public function updateFAQ($id, $data)
    {
        return $this->update($id, $data);
    }
    
    // Delete FAQ
    public function deleteFAQ($id)
    {
        return $this->delete($id);
    }

    public function getAllActiveFAQs()
    {
        try {
            return $this->where('fld_status', 1)
                        ->orderBy('id', 'ASC')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error in FAQModel::getAllActiveFAQs: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getFAQsByProduct($productId)
    {
        try {
            return $this->where('fld_product_id', $productId)
                        ->where('fld_status', 1)
                        ->orderBy('id', 'ASC')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error in FAQModel::getFAQsByProduct: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getGeneralFAQs()
    {
        try {
            return $this->where('fld_product_id', null)
                        ->where('fld_status', 1)
                        ->orderBy('id', 'ASC')
                        ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error in FAQModel::getGeneralFAQs: ' . $e->getMessage());
            return [];
        }
    }
}