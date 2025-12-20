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
        
        // Get site settings
        $siteSettingsModel = new \App\Models\SiteSettingsModel();
        $siteSettings = $siteSettingsModel->first();
        
        if (empty($siteSettings['fld_ebook'])) {
            return redirect()->back()->with('error', 'E-book not available');
        }
        
        $filePath = ROOTPATH . 'public/' . $siteSettings['fld_ebook'];
        
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        } else {
            return redirect()->back()->with('error', 'E-book file not found');
        }
    }
}