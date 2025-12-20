<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiteSettingsModel;

class SiteSettings extends BaseController
{
    protected $settingsModel;
    
    public function __construct()
    {
        $this->settingsModel = new SiteSettingsModel();
        helper('text');
    }
    
    // Show site settings form
    public function index()
    {
        $data['settings'] = $this->settingsModel->getSettings();
        $data['title'] = 'Site Settings';
        
        return view('admin/site_settings/index', $data);
    }
    
    // Update site settings
    public function update()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'site_title' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'mobile' => 'required|min_length[10]|max_length[20]',
            'meta_description' => 'permit_empty|max_length[255]',
            'meta_keywords' => 'permit_empty|max_length[255]',
            'hidden_gems' => 'required|numeric',
            'youtube_subscribers' => 'required|numeric',
            'investors_empowered' => 'required|numeric',
            'years_experience' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Handle header logo upload
        $headerLogo = $this->request->getPost('current_header_logo');
        if ($file = $this->request->getFile('header_logo')) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Delete old logo if exists
                if (!empty($this->request->getPost('current_header_logo')) && file_exists($this->request->getPost('current_header_logo'))) {
                    unlink($this->request->getPost('current_header_logo'));
                }
                
                $newName = $file->getRandomName();
                $file->move('uploads/site', $newName);
                $headerLogo = 'uploads/site/' . $newName;
            }
        }
        
        // Handle footer logo upload
        $footerLogo = $this->request->getPost('current_footer_logo');
        if ($file = $this->request->getFile('footer_logo')) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Delete old logo if exists
                if (!empty($this->request->getPost('current_footer_logo')) && file_exists($this->request->getPost('current_footer_logo'))) {
                    unlink($this->request->getPost('current_footer_logo'));
                }
                
                $newName = $file->getRandomName();
                $file->move('uploads/site', $newName);
                $footerLogo = 'uploads/site/' . $newName;
            }
        }
        
        // Handle ebook upload
        $ebook = $this->request->getPost('current_ebook');
        if ($file = $this->request->getFile('ebook')) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Delete old ebook if exists
                if (!empty($this->request->getPost('current_ebook')) && file_exists($this->request->getPost('current_ebook'))) {
                    unlink($this->request->getPost('current_ebook'));
                }
                
                $newName = $file->getRandomName();
                $file->move('uploads/ebooks', $newName);
                $ebook = 'uploads/ebooks/' . $newName;
            }
        }
        
        $data = [
            'fld_header_logo' => $headerLogo,
            'fld_footer_logo' => $footerLogo,
            'fld_site_title' => $this->request->getPost('site_title'),
            'fld_meta_description' => $this->request->getPost('meta_description'),
            'fld_meta_keywords' => $this->request->getPost('meta_keywords'),
            'fld_full_address' => $this->request->getPost('full_address'),
            'fld_latitude' => $this->request->getPost('latitude'),
            'fld_longitude' => $this->request->getPost('longitude'),
            'fld_email' => $this->request->getPost('email'),
            'fld_mobile' => $this->request->getPost('mobile'),
            'fld_ebook' => $ebook,
            'fld_hidden_gems' => $this->request->getPost('hidden_gems'),
            'fld_youtube_subscribers' => $this->request->getPost('youtube_subscribers'),
            'fld_investors_empowered' => $this->request->getPost('investors_empowered'),
            'fld_years_experience' => $this->request->getPost('years_experience')
        ];
        
        $this->settingsModel->updateSettings($data);
        
        return redirect()->to('/admin/settings')->with('success', 'Site settings updated successfully');
    }
}