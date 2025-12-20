<?php

namespace App\Models;

use CodeIgniter\Model;

class QuarterlyUpdateModel extends Model
{
    protected $table = 've_quarterly_updates';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_product_id', 'fld_title', 'fld_video_url', 'fld_description', 'fld_status'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
}
