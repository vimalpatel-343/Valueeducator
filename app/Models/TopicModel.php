<?php

namespace App\Models;

use CodeIgniter\Model;

class TopicModel extends Model
{
    protected $table = 've_sector_content';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'sector_id', 'name', 'icon', 'description', 'sort_order', 'active',
        'created_by', 'created_ip', 'created_at', 'updated_by', 'updated_ip', 'updated_at'
    ];
    
    // Get topics with sector information
    public function getTopicsWithSector($sectorId = null)
    {
        $builder = $this->select('ve_sector_content.*, sector.name as sector_name')
                        ->join('sector', 'sector.id = ve_sector_content.sector_id')
                        ->where('sector.used_for', 1)
                        ->orderBy('ve_sector_content.sort_order', 'ASC');
        
        if ($sectorId) {
            $builder->where('ve_sector_content.sector_id', $sectorId);
        }
        
        return $builder;
    }
    
    // Get all topics with pagination
    public function getAllTopics($sectorId = null)
    {
        $builder = $this->getTopicsWithSector($sectorId);
        return $builder->paginate(20);
    }
    
    // Get active topics for frontend
    public function getActiveTopics($sectorId = null)
    {
        $builder = $this->getTopicsWithSector($sectorId)
                        ->where('ve_sector_content.active', 1);
        return $builder->findAll();
    }
    
    // Get sectors for dropdown (only knowledge sectors)
    public function getKnowledgeSectors()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sector')
                      ->where('used_for', 1)
                      ->where('active', 1)
                      ->orderBy('sort_order', 'ASC');
        return $builder->get()->getResultArray();
    }
    
    // Update sort order
    public function updateSortOrder($data)
    {
        foreach ($data as $id => $sortOrder) {
            $this->update($id, ['sort_order' => $sortOrder]);
        }
        return true;
    }
    
    // Delete topic and associated icon
    public function deleteTopic($id)
    {
        $topic = $this->find($id);
        if ($topic) {
            // Delete icon if exists
            if (!empty($topic['icon']) && file_exists($topic['icon'])) {
                unlink($topic['icon']);
            }
            return $this->delete($id);
        }
        return false;
    }
}