<?php 

namespace App\Models;

use CodeIgniter\Model;

class KnowledgeItemModel extends Model
{
    protected $table = 've_knowledge_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_category_id', 'fld_title', 'fld_video_url', 'fld_duration', 
        'fld_description', 'fld_posted_at', 'fld_status'
    ];
    
    // Get items with category name
    public function getItemsWithCategory()
    {
        return $this->select('ve_knowledge_items.*, ve_knowledge_categories.fld_title as category_title')
                    ->join('ve_knowledge_categories', 've_knowledge_categories.id = ve_knowledge_items.fld_category_id')
                    ->findAll();
    }
    
    // Get item by ID with category name
    public function getItemWithCategory($id)
    {
        return $this->select('ve_knowledge_items.*, ve_knowledge_categories.fld_title as category_title')
                    ->join('ve_knowledge_categories', 've_knowledge_categories.id = ve_knowledge_items.fld_category_id')
                    ->where('ve_knowledge_items.id', $id)
                    ->first();
    }
}