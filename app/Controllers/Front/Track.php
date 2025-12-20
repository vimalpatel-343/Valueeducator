<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class Track extends BaseController
{
    public function ebookDownload()
    {
        if ($this->request->isAJAX()) {
            $ebookUrl = $this->request->getPost('url');
            
            // Only track if user is logged in
            if (session()->get('isLoggedIn')) {
                $userId = session()->get('userId');
                
                // Save download tracking to database
                $db = \Config\Database::connect();
                
                $downloadData = [
                    'fld_user_id' => $userId,
                    'fld_ebook_url' => $ebookUrl,
                    'fld_download_time' => date('Y-m-d H:i:s')
                ];
                
                $db->table('ve_ebook_downloads')->insert($downloadData);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Download tracked successfully'
            ]);
        }
        
        return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Access denied']);
    }
}