<?php namespace App\Models;

use CodeIgniter\Model;

class RebalanceTimelineModel extends Model
{
    protected $table = 've_rebalance_timelines';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_id',
        'fld_date',
        'fld_constituents_plus',
        'fld_constituents_minus',
        'fld_factsheet_url',
        'fld_description',
        'fld_status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
}