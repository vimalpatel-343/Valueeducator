<?php

namespace App\Models;

use CodeIgniter\Model;

class TrackingModel extends Model
{
    protected $table = 've_tracking_data';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id', 'session_id', 'referrer_url', 'source', 'medium', 
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term',
        'landing_page', 'ip_address', 'device', 'browser', 'first_visit_time', 
        'last_visit_time', 'is_converted'
    ];
    
    // Store tracking data
    public function storeTrackingData($data)
    {
        // Check if session already exists
        $existing = $this->where('session_id', $data['session_id'])->first();
        
        if ($existing) {
            // Update existing record
            $this->update($existing['id'], $data);
            return $existing['id'];
        } else {
            // Insert new record
            $this->insert($data);
            return $this->getInsertID();
        }
    }
    
    // Mark conversion when user makes a purchase
    public function markConversion($userId)
    {
        return $this->where('user_id', $userId)->set(['is_converted' => 1])->update();
    }
    
    // Get paginated tracking data
    public function getPaginatedData($perPage = null)
    {
        // Set default per page if not provided
        if ($perPage === null) {
            $perPage = 20;
        }
        
        return $this->orderBy('created_at', 'DESC')
                    ->paginate($perPage);
    }
    
    // Get tracking data with filters
    public function getFilteredData($filters = [], $perPage = null)
    {
        // Set default per page if not provided
        if ($perPage === null) {
            $perPage = 20;
        }
        
        $builder = $this->orderBy('created_at', 'DESC');
        
        // Apply filters if provided
        if (!empty($filters['source'])) {
            $builder->where('source', $filters['source']);
        }
        
        if (!empty($filters['medium'])) {
            $builder->where('medium', $filters['medium']);
        }
        
        if (!empty($filters['utm_campaign'])) {
            $builder->where('utm_campaign', $filters['utm_campaign']);
        }
        
        if (!empty($filters['is_converted']) !== null) {
            $builder->where('is_converted', $filters['is_converted']);
        }
        
        if (!empty($filters['date_from'])) {
            $builder->where('created_at >=', $filters['date_from'] . ' 00:00:00');
        }
        
        if (!empty($filters['date_to'])) {
            $builder->where('created_at <=', $filters['date_to'] . ' 23:59:59');
        }
        
        return $builder->paginate($perPage);
    }
    
    // Get tracking statistics
    public function getSourceStats()
    {
        return $this->select('source, COUNT(*) as count')
                    ->groupBy('source')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }
    
    public function getMediumStats()
    {
        return $this->select('medium, COUNT(*) as count')
                    ->groupBy('medium')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }
    
    public function getCampaignStats()
    {
        return $this->select('utm_campaign, COUNT(*) as count')
                    ->where('utm_campaign IS NOT NULL')
                    ->groupBy('utm_campaign')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }
    
    // Get unique sources for filter dropdown
    public function getUniqueSources()
    {
        return $this->select('source')
                    ->distinct()
                    ->orderBy('source', 'ASC')
                    ->findAll();
    }
    
    // Get unique mediums for filter dropdown
    public function getUniqueMediums()
    {
        return $this->select('medium')
                    ->distinct()
                    ->orderBy('medium', 'ASC')
                    ->findAll();
    }
    
    // Get unique campaigns for filter dropdown
    public function getUniqueCampaigns()
    {
        return $this->select('utm_campaign')
                    ->where('utm_campaign IS NOT NULL')
                    ->distinct()
                    ->orderBy('utm_campaign', 'ASC')
                    ->findAll();
    }
}