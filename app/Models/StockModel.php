<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table = 've_stocks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'fld_product_id', 
        'fld_stock_name', 
        'fld_date_of_recommendation', 
        'fld_price_at_recommendation', 
        'fld_cmp', 
        'fld_returns', 
        'fld_allocation', 
        'fld_action', 
        'fld_report_url', 
        'fld_sector', 
        'fld_rating', 
        'fld_status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fld_created_at';
    protected $updatedField = 'fld_updated_at';

    // Get stocks by product ID
    public function getStocksByProduct($productId)
    {
        return $this->where('fld_product_id', $productId)
                    ->where('fld_status', 1)
                    ->orderBy('fld_date_of_recommendation', 'DESC')
                    ->findAll();
    }
    
    // Get stock by report URL/filename
    public function getStockByReportFilename($filename)
    {
        // Extract just the filename from the report_url if it contains a path
        $justFilename = basename($filename);
        return $this->where('fld_report_url', $justFilename)->first();
    }
    
    // Get stock by report URL with full path
    public function getStockByReportUrl($reportUrl)
    {
        return $this->where('fld_report_url', $reportUrl)->first();
    }
    
    // Extract stock information from filename
    public function extractStockFromFilename($filename)
    {
        // Try to find stock by exact filename match
        $stock = $this->getStockByReportFilename($filename);
        if ($stock) {
            return $stock;
        }
        
        // Try with full path
        $fullPath = 'uploads/stocks/reports/' . $filename;
        $stock = $this->getStockByReportUrl($fullPath);
        if ($stock) {
            return $stock;
        }
        
        // If no exact match, try to extract stock name from filename
        // This depends on your naming convention
        
        // Try to extract stock name from filename if it contains the stock name
        if (preg_match('/([A-Za-z0-9]+)_.*\.pdf$/i', $filename, $matches)) {
            $stockName = $matches[1];
            $stock = $this->getStockBySymbol($stockName);
            if ($stock) {
                return $stock;
            }
        }
        
        // If filename is like "report22.pdf", try to find by numeric ID
        if (preg_match('/report(\d+)\.pdf$/i', $filename, $matches)) {
            $reportId = $matches[1];
            // You might have a mapping table for report IDs to stocks
            // For now, return null
        }
        
        return null;
    }
    
    // Get stock by symbol/name
    public function getStockBySymbol($symbol)
    {
        return $this->where('fld_stock_name', $symbol)->first();
    }
}