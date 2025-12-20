<?php 

namespace App\Models;

use CodeIgniter\Model;

class AppImageModel extends Model
{
    protected $table = 've_app_images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_id', 'fld_image', 'fld_display_order'
    ];

    // Get images by product ID
    public function getImagesByProductId($productId)
    {
        return $this->where('fld_product_id', $productId)
                    ->orderBy('fld_display_order', 'ASC')
                    ->findAll();
    }
}