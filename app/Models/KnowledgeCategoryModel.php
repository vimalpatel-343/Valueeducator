<?php 

namespace App\Models;

use CodeIgniter\Model;

class KnowledgeCategoryModel extends Model
{
    protected $table = 've_knowledge_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_title', 'fld_slug', 'fld_image', 'fld_status'
    ];
    
    // Generate slug from title
    public function generateSlug($title)
    {
        $slug = url_title($title, '-', true);
        $count = 0;
        $originalSlug = $slug;
        
        while ($this->where('fld_slug', $slug)->first()) {
            $count++;
            $slug = $originalSlug . '-' . $count;
        }
        
        return $slug;
    }
}