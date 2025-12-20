<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteSettingsModel extends Model
{
    protected $table = 've_site_settings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'fld_header_logo', 'fld_footer_logo', 'fld_site_title', 'fld_meta_description', 
        'fld_meta_keywords', 'fld_full_address', 'fld_latitude', 'fld_longitude', 
        'fld_email', 'fld_mobile', 'fld_ebook', 'fld_hidden_gems', 
        'fld_youtube_subscribers', 'fld_investors_empowered', 'fld_years_experience'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';
    
    // Get site settings
    public function getSettings()
    {
        // Since we only have one row, we get the first record
        $settings = $this->first();
        
        // If no settings exist, create default settings
        if (!$settings) {
            $data = [
                'fld_site_title' => 'Value Educator',
                'fld_email' => 'info@valueeducator.com',
                'fld_mobile' => '+91 9876543210'
            ];
            $this->insert($data);
            $settings = $this->first();
        }
        
        return $settings;
    }
    
    // Update site settings
    public function updateSettings($data)
    {
        $settings = $this->first();
        
        if ($settings) {
            return $this->update($settings['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    public function getStatistic($key)
    {
        return $this->where('fld_key', $key)->first();
    }
}