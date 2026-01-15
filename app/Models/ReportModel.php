<?php namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table = 've_reports';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'company_name',
        'sector_id',
        'market_cap',
        'description',
        'logo',
        'active',
        'recommended',
        'sort_order',
        'created_by',
        'created_ip',
        'created_datetime',
        'modified_by',
        'modified_ip',
        'modified_datetime'
    ];
    protected $useTimestamps = false;
    
    // Get reports with sector information (with pagination)
    public function getReportsWithSector($perPage = 20, $filters = [])
    {
        $builder = $this->select('ve_reports.*, ve_sector.name as sector_name, ve_sector.icon as sector_icon')
                        ->join('ve_sector', 've_sector.id = ve_reports.sector_id')
                        ->where('ve_reports.active', 1)
                        ->where('ve_sector.active', 1);
        
        // Apply filters
        if (isset($filters['market_cap']) && $filters['market_cap'] != 'all') {
            $builder->where('ve_reports.market_cap', $filters['market_cap']);
        }
        
        if (isset($filters['sector_id']) && !empty($filters['sector_id'])) {
            
            $sectorIds = is_array($filters['sector_id'])
                ? $filters['sector_id']
                : [$filters['sector_id']];

            $builder->whereIn('ve_reports.sector_id', $sectorIds);
        }
        
        if (isset($filters['recommended']) && $filters['recommended'] == 1) {
            $builder->where('ve_reports.recommended', 1);
        }
        
        if (isset($filters['favorites']) && $filters['favorites'] == 1 && !empty($filters['user_id'])) {
            $builder->join('ve_user_favorites', 've_user_favorites.report_id = ve_reports.id')
                    ->where('ve_user_favorites.user_id', $filters['user_id']);
        }
        
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            $builder->like('ve_reports.company_name', $filters['keyword']);
        }
        
        return $builder->orderBy('ve_reports.sort_order', 'ASC')->paginate($perPage);
    }
    
    // Get all reports with sector information (without pagination)
    public function getAllReportsWithSector($filters = [])
    {
        $builder = $this->select('ve_reports.*, ve_sector.name as sector_name, ve_sector.icon as sector_icon')
                        ->join('ve_sector', 've_sector.id = ve_reports.sector_id')
                        ->where('ve_reports.active', 1)
                        ->where('ve_sector.active', 1);
        
        // Apply filters
        if (isset($filters['market_cap']) && $filters['market_cap'] != 'all') {
            $builder->where('ve_reports.market_cap', $filters['market_cap']);
        }
        
        if (isset($filters['sector_id']) && !empty($filters['sector_id'])) {
            $builder->whereIn('ve_reports.sector_id', $filters['sector_id']);
        }
        
        if (isset($filters['recommended']) && $filters['recommended'] == 1) {
            $builder->where('ve_reports.recommended', 1);
        }
        
        if (isset($filters['favorites']) && $filters['favorites'] == 1 && !empty($filters['user_id'])) {
            $builder->join('ve_user_favorites', 've_user_favorites.report_id = ve_reports.id')
                    ->where('ve_user_favorites.user_id', $filters['user_id']);
        }
        
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            $builder->like('ve_reports.company_name', $filters['keyword']);
        }
        
        return $builder->orderBy('ve_reports.sort_order', 'ASC')->findAll();
    }
    
    // Get market cap options
    public function getMarketCapOptions()
    {
        return [
            'all' => 'All Caps',
            '1' => 'Large Cap',
            '2' => 'Mid Cap',
            '3' => 'Small Cap',
            '4' => 'Micro Cap'
        ];
    }
    
    // Get market cap label by value
    public function getMarketCapLabel($value)
    {
        $options = $this->getMarketCapOptions();
        return isset($options[$value]) ? $options[$value] : 'Unknown';
    }
    
    // Get sectors for reports (used_for = 2)
    public function getReportSectors()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ve_sector')
                      ->where('used_for', 2)
                      ->where('active', 1)
                      ->orderBy('sort_order', 'ASC');
        return $builder->get()->getResultArray();
    }
    
    // Check if a report is favorited by a user
    public function isFavorited($reportId, $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ve_user_favorites')
                      ->where('report_id', $reportId)
                      ->where('user_id', $userId);
        return $builder->countAllResults() > 0;
    }
    
    // Toggle favorite status
    public function toggleFavorite($reportId, $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ve_user_favorites');
        
        // Check if already favorited
        $exists = $builder->where('report_id', $reportId)
                         ->where('user_id', $userId)
                         ->countAllResults() > 0;
        
        if ($exists) {
            // Remove from favorites
            $builder->where('report_id', $reportId)
                   ->where('user_id', $userId)
                   ->delete();
            return ['status' => 'removed', 'message' => 'Removed from favorites'];
        } else {
            // Add to favorites
            $data = [
                'report_id' => $reportId,
                'user_id' => $userId,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $builder->insert($data);
            return ['status' => 'added', 'message' => 'Added to favorites'];
        }
    }
}