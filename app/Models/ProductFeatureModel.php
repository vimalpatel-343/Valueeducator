<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductFeatureModel extends Model
{
    protected $table = 've_product_features';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_id', 'fld_title', 'fld_image', 'fld_description', 'fld_status'
    ];

    // Get features by product ID
    public function getFeaturesByProductId($productId)
    {
        return $this->where('fld_product_id', $productId)
                    ->where('fld_status', 1)
                    ->findAll();
    }
}