<?php
namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ContentPagesModel;
use App\Models\FAQModel;

class Content extends BaseController
{
    protected $contentPagesModel;
    
    public function __construct()
    {
        $this->contentPagesModel = new ContentPagesModel();     
        $this->faqModel = new FAQModel();   
    }
    
    public function index($pageType = null)
    {
        if (!$pageType) {
            return redirect()->to('/');
        }
        
        // Get site settings
        $data['siteSettings'] = $this->getSiteSettings();
        
        // Get page content
        $page = $this->contentPagesModel->getPageByType($pageType);
        
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Set meta tags
        $data['meta'] = [
            'title' => $page['fld_title'] . ' - ' . $data['siteSettings']['fld_site_title'],
            'description' => $this->generateMetaDescription($page['fld_content']),
            'keywords' => $data['siteSettings']['fld_meta_keywords']
        ];
        
        $data['page'] = $page;
        
        // Determine which view to use based on page type
        $viewName = $this->getViewName($pageType);
        
        return view($viewName, $data);
    }
    
    private function generateMetaDescription($content)
    {
        // Strip HTML tags and limit to 160 characters
        $plainText = strip_tags($content);
        if (strlen($plainText) > 160) {
            return substr($plainText, 0, 157) . '...';
        }
        return $plainText;
    }
    
    private function getViewName($pageType)
    {
        // Map page types to view files
        $viewMap = [
            'disclosure' => 'front/content/disclosure',
            'grievance' => 'front/content/grievance',
            'investor_charter' => 'front/content/investor_charter',
            'privacy_policy' => 'front/content/privacy_policy',
            'terms_conditions' => 'front/content/terms_conditions',
            'refund_cancellation' => 'front/content/refund_cancellation',
            'complaint_data' => 'front/content/complaint_data',
            'otp_page'   => 'front/content/otp_page',
        ];
        
        return $viewMap[$pageType] ?? 'front/content/default';
    }
    
    // Keep existing methods for backward compatibility
    public function investorCharter()
    {
        return $this->index('investor_charter');
    }
    
    public function investmentPhilosophy()
    {
        $data['siteSettings'] = $this->getSiteSettings();
        $data['meta'] = [
            'title' => 'Investment Philosophy - ' . $data['siteSettings']['fld_site_title'],
            'description' => $data['siteSettings']['fld_meta_description'],
            'keywords' => $data['siteSettings']['fld_meta_keywords']
        ];
        
        return view('front/investment_philosophy', $data);
    }

    public function complaintData()
    {
        $data['siteSettings'] = $this->getSiteSettings();
        $data['meta'] = [
            'title' => 'About Us - ' . $data['siteSettings']['fld_site_title'],
            'description' => $data['siteSettings']['fld_meta_description'],
            'keywords' => $data['siteSettings']['fld_meta_keywords']
        ];
        
        return view('front/complaint_data', $data);
    }

    public function aboutUs()
    {
        // Get site settings
        $data['siteSettings'] = $this->getSiteSettings();
        
        // Set meta tags
        $data['meta'] = [
            'title' => 'About Us - ' . $data['siteSettings']['fld_site_title'],
            'description' => 'Learn about Value Educator, our mission, vision, and core values. Discover why we are the trusted partner for investment research and advisory services.',
            'keywords' => 'about Value Educator, investment philosophy, mission, vision, core values'
        ];
        
        return view('front/about_us', $data);
    }

    public function productFAQs()
    {
        // Get site settings
        $data['siteSettings'] = $this->getSiteSettings();
        
        // Get general FAQs (not associated with any product)
        $data['generalFAQs'] = $this->faqModel->getGeneralFAQs();
        
        // Get product-specific FAQs
        $data['productFAQs'] = $this->faqModel->getAllActiveFAQs();
        
        // Set meta tags
        $data['meta'] = [
            'title' => 'Product FAQs (Frequently Asked Questions) - ' . $data['siteSettings']['fld_site_title'],
            'description' => 'Find answers to frequently asked questions about our investment services and products. Get clarity on our research approach and subscription benefits.',
            'keywords' => 'FAQs, frequently asked questions, investment queries, research services'
        ];
        
        return view('front/product_faqs', $data);
    }
}