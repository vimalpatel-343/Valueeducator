<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardScuttlebuttModel extends Model
{
    protected $table = 've_dashboard_scuttlebutt';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_id', 
        'fld_updated_date', 
        'fld_image', 
        'fld_description', 
        'fld_status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get dashboard scuttlebutt by product ID
    public function getByProductId($productId)
    {
        return $this->where('fld_product_id', $productId)
                    ->where('fld_status', 1)
                    ->first();
    }
    
    // Save or update dashboard scuttlebutt
    public function saveDashboardScuttlebutt($productId, $data)
    {
        $existing = $this->getByProductId($productId);
        
        if ($existing) {
            // Update existing record
            return $this->update($existing['id'], $data);
        } else {
            // Insert new record
            $data['fld_product_id'] = $productId;
            return $this->insert($data);
        }
    }
}