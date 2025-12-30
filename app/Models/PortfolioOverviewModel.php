<?php 

namespace App\Models;

use CodeIgniter\Model;

class PortfolioOverviewModel extends Model
{
    protected $table = 've_portfolio_overviews';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fld_product_id', 'fld_stocks_count', 'fld_last_recommendation_date', 
        'fld_top_sectors', 'fld_upcoming_review', 'fld_average_market_cap', 
        'fld_dependency_on_us_economy', 'fld_disclaimer', 'fld_overview_allocation', 'fld_overview_cash'
    ];
}