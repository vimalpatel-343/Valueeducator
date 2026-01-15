<?php

namespace App\Models;

use CodeIgniter\Model;

class SectorModel extends Model
{
    protected $table = 'sector';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'name', 'image', 'icon', 'active', 'used_for', 
        'sort_order', 'created_by', 'created_ip', 'created_datetime',
        'modified_by', 'modified_ip', 'modified_datetime'
    ];
    
    // Get sectors for knowledge center (used_for = 1)
    public function getKnowledgeSectors()
    {
        return $this->where('used_for', 1)
                   ->where('active', 1)
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }
    
    // Get sectors for reports (used_for = 2)
    public function getReportSectors()
    {
        return $this->where('used_for', 2)
                   ->where('active', 1)
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }
    
    // Get all sectors with pagination
    public function getAllSectors($usedFor = null)
    {
        $builder = $this->orderBy('sort_order', 'ASC');
        
        if ($usedFor !== null) {
            $builder->where('used_for', $usedFor);
        }
        
        return $builder;
    }
    
    // Update sort order
    public function updateSortOrder($data)
    {
        foreach ($data as $id => $sortOrder) {
            $this->update($id, ['sort_order' => $sortOrder]);
        }
        return true;
    }
}