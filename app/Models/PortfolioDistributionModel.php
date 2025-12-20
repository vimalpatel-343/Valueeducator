<?php 

namespace App\Models;

use CodeIgniter\Model;

class PortfolioDistributionModel extends Model
{
    protected $table = 've_portfolio_distributions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_id', 'fld_category', 'fld_percentage'
    ];
}