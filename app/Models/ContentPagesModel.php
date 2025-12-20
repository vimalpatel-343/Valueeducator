<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentPagesModel extends Model
{
    protected $table = 've_content_pages';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_page_type', 'fld_title', 'fld_content', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get content page by type
    public function getContentByType($pageType)
    {
        return $this->where('fld_page_type', $pageType)->first();
    }
    
    // Get content page by ID
    public function getContentById($id)
    {
        return $this->find($id);
    }
    
    // Create new content page
    public function createContent($data)
    {
        return $this->insert($data);
    }
    
    // Update content page
    public function updateContent($id, $data)
    {
        return $this->update($id, $data);
    }
    
    // Delete content page
    public function deleteContent($id)
    {
        return $this->delete($id);
    }

    public function getPageByType($pageType)
    {
        try {
            return $this->where('fld_page_type', $pageType)
                        ->where('fld_status', 1)
                        ->first();
        } catch (\Exception $e) {
            log_message('error', 'Error in ContentPagesModel::getPageByType: ' . $e->getMessage());
            return null;
        }
    }
}