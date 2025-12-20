<?php namespace App\Models;

use CodeIgniter\Model;

class ScuttlebuttNotesModel extends Model
{
    protected $table = 've_scuttlebutt_notes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_id',
        'fld_title',
        'fld_date',
        'fld_description',
        'fld_status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';

    // Get active notes by product ID
    public function getActiveNotesByProductId($productId)
    {
        return $this->where('fld_product_id', $productId)
                    ->where('fld_status', 1)
                    ->orderBy('fld_date', 'DESC')
                    ->findAll();
    }
    
    // Get all active notes
    public function getAllActiveNotes()
    {
        return $this->where('fld_status', 1)
                    ->orderBy('fld_date', 'DESC')
                    ->findAll();
    }
}