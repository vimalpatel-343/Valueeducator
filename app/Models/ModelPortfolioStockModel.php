<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPortfolioStockModel extends Model
{
    protected $table = 've_stocks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_product_id', 'fld_stock_name', 'fld_date_of_recommendation', 'fld_price_at_recommendation', 'fld_allocation', 'fld_action', 'fld_report_url', 'fld_sector', 'fld_rating', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
}