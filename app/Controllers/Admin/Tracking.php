<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TrackingModel;

class Tracking extends BaseController
{
    protected $trackingModel;
    
    public function __construct()
    {
        $this->trackingModel = new TrackingModel();
    }
    
    // Display tracking data
    public function index()
    {
        $data['title'] = 'UTM Tracking Data';
        
        // Get per page setting from session or default
        $session = session();
        $perPage = $session->get('tracking_per_page') ?? 20;
        
        // Handle per page change
        if ($this->request->getGet('per_page')) {
            $perPage = $this->request->getGet('per_page');
            $session->set('tracking_per_page', $perPage);
            return redirect()->to(current_url());
        }
        
        // Get filters from request
        $filters = [
            'source' => $this->request->getGet('source'),
            'medium' => $this->request->getGet('medium'),
            'utm_campaign' => $this->request->getGet('utm_campaign'),
            'is_converted' => $this->request->getGet('is_converted'),
            'date_from' => $this->request->getGet('date_from'),
            'date_to' => $this->request->getGet('date_to')
        ];
        
        // Remove empty filters
        $filters = array_filter($filters, function($value) {
            return $value !== '' && $value !== null;
        });
        
        // Get tracking data
        if (!empty($filters)) {
            $data['trackingData'] = $this->trackingModel->getFilteredData($filters, $perPage);
        } else {
            $data['trackingData'] = $this->trackingModel->getPaginatedData($perPage);
        }
        
        $data['pager'] = $this->trackingModel->pager;
        $data['perPage'] = $perPage;
        $data['filters'] = $filters;
        
        // Get filter options
        $data['sources'] = $this->trackingModel->getUniqueSources();
        $data['mediums'] = $this->trackingModel->getUniqueMediums();
        $data['campaigns'] = $this->trackingModel->getUniqueCampaigns();
        
        return view('admin/tracking/index', $data);
    }
    
    // Get tracking statistics
    public function statistics()
    {
        $data['title'] = 'Tracking Statistics';
        
        // Get source statistics
        $data['sourceStats'] = $this->trackingModel->getSourceStats();
        
        // Get medium statistics
        $data['mediumStats'] = $this->trackingModel->getMediumStats();
        
        // Get campaign statistics
        $data['campaignStats'] = $this->trackingModel->getCampaignStats();
        
        // Get conversion statistics
        $data['conversionStats'] = [
            'total' => $this->trackingModel->countAll(),
            'converted' => $this->trackingModel->where('is_converted', 1)->countAllResults(),
            'conversion_rate' => 0
        ];
        
        if ($data['conversionStats']['total'] > 0) {
            $data['conversionStats']['conversion_rate'] = 
                ($data['conversionStats']['converted'] / $data['conversionStats']['total']) * 100;
        }
        
        return view('admin/tracking/statistics', $data);
    }
}