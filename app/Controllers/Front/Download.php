<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class Download extends BaseController
{
    public function ebook()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url());
        }
        
        $userId = session()->get('userId');
        
        // Get site settings
        $siteSettingsModel = new \App\Models\SiteSettingsModel();
        $siteSettings = $siteSettingsModel->first();
        
        if (empty($siteSettings['fld_ebook'])) {
            return redirect()->back()->with('error', 'E-book not available');
        }
        
        $filePath = ROOTPATH . 'public/' . $siteSettings['fld_ebook'];
        
        if (file_exists($filePath)) {
            // Track the download
            $this->trackEbookDownload($userId);
            
            return $this->response->download($filePath, null);
        } else {
            return redirect()->back()->with('error', 'E-book file not found');
        }
    }
    
    private function trackEbookDownload($userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ve_user_ebook_downloads');
        
        // Check if user already has a download record
        $existingRecord = $builder->where('fld_user_id', $userId)->get()->getRow();
        
        // if ($existingRecord) {
        //     // Update existing record
        //     $builder->set('fld_download_count', 'fld_download_count + 1', false)
        //             ->set('fld_last_download_date', date('Y-m-d'))
        //             ->set('fld_updated_at', date('Y-m-d H:i:s'))
        //             ->where('fld_user_id', $userId)
        //             ->update();
        // } else {
            // Create new record
            $data = [
                'fld_user_id' => $userId,
                'fld_download_count' => 1,
                'fld_last_download_date' => date('Y-m-d'),
                'fld_created_at' => date('Y-m-d H:i:s'),
                'fld_updated_at' => date('Y-m-d H:i:s')
            ];
            $builder->insert($data);
        //}
    }
    
    // Method to check if user has downloaded the ebook
    public function hasUserDownloadedEbook($userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ve_user_ebook_downloads');
        $result = $builder->where('fld_user_id', $userId)->get()->getRow();
        
        return $result && $result->download_count > 0;
    }
}