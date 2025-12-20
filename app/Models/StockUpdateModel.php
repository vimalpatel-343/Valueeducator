<?php

namespace App\Models;

use CodeIgniter\Model;

class StockUpdateModel extends Model
{
    protected $table = 've_stock_updates';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'fld_product_id', 
        'fld_stock_id', 
        'fld_update_date', 
        'fld_description', 
        'fld_status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get stock updates with stock names
    public function getStockUpdatesWithNames($productId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ve_stock_updates su');
        $builder->select('su.*, s.fld_stock_name');
        $builder->join('ve_stocks s', 'su.fld_stock_id = s.id', 'left');
        $builder->where('su.fld_product_id', $productId);
        $builder->where('su.fld_status', 1);
        $builder->orderBy('su.fld_update_date', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getStockUpdateByStockId($productId, $stockId)
    {
        return $this->where('fld_product_id', $productId)
                    ->where('fld_stock_id', $stockId)
                    ->where('fld_status', 1)
                    ->orderBy('fld_update_date', 'DESC')
                    ->findAll();
    }
}