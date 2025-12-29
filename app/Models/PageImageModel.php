<?php

namespace App\Models;

use CodeIgniter\Model;

class PageImageModel extends Model
{
    protected $table = 've_page_images';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'page_name', 'section_name', 'image_path', 'image_alt', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get all images grouped by page
    public function getImagesGroupedByPage()
    {
        $images = $this->where('status', 1)->findAll();
        $result = [];
        
        foreach ($images as $image) {
            if (!isset($result[$image['page_name']])) {
                $result[$image['page_name']] = [];
            }
            $result[$image['page_name']][$image['section_name']] = $image;
        }
        
        return $result;
    }
    
    // Get image by page and section
    public function getImageByPageSection($pageName, $sectionName)
    {
        return $this->where('page_name', $pageName)
                    ->where('section_name', $sectionName)
                    ->where('status', 1)
                    ->first();
    }
    
    // Get all pages that have images
    public function getPagesWithImages()
    {
        return $this->distinct()->select('page_name')->findAll();
    }
    
    // Get all sections for a specific page
    public function getSectionsByPage($pageName)
    {
        return $this->where('page_name', $pageName)
                    ->where('status', 1)
                    ->findAll();
    }
}