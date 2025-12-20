<?php

namespace App\Models;

use CodeIgniter\Model;

class ManagementInterviewModel extends Model
{
    protected $table = 've_management_interviews';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['fld_product_id', 'fld_title', 'fld_video_url', 'fld_description'];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
}