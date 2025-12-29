<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductFeatureModel;
use App\Models\AppImageModel;
use App\Models\PortfolioOverviewModel;
use App\Models\PortfolioDistributionModel;
use App\Models\QuarterlyUpdateModel;
use App\Models\ManagementInterviewModel;
use App\Models\StockModel;
use App\Models\StockUpdateModel;
use App\Models\RebalanceTimelineModel;
use App\Models\ScuttlebuttNotesModel;
use App\Models\DashboardScuttlebuttModel;

class Products extends BaseController
{
    protected $productModel;
    protected $productFeatureModel;
    protected $appImageModel;
    protected $portfolioOverviewModel;
    protected $portfolioDistributionModel;
    protected $quarterlyUpdateModel;
    protected $managementInterviewModel;
    protected $stockModel;
    protected $stockUpdateModel;
    protected $rebalanceTimelineModel;
    protected $scuttlebuttNotesModel; 
    protected $dashboardScuttlebuttModel;

    public function __construct()
    {
        helper('common');
        
        $this->productModel = new ProductModel();
        $this->productFeatureModel = new ProductFeatureModel();
        $this->appImageModel = new AppImageModel();
        $this->portfolioOverviewModel = new PortfolioOverviewModel();
        $this->portfolioDistributionModel = new PortfolioDistributionModel();
        $this->quarterlyUpdateModel = new QuarterlyUpdateModel();
        $this->managementInterviewModel = new ManagementInterviewModel();
        $this->stockModel = new StockModel();
        $this->stockUpdateModel = new StockUpdateModel();
        $this->rebalanceTimelineModel = new RebalanceTimelineModel();
        $this->scuttlebuttNotesModel = new ScuttlebuttNotesModel();
        $this->dashboardScuttlebuttModel = new DashboardScuttlebuttModel();
    }

    // List all products
    public function index()
    {
        $data = [
            'products' => $this->productModel->findAll(),
            'title' => 'Product Management'
        ];
        
        return view('admin/products/index', $data);
    }

    // Show create product form
    public function create()
    {
        $data = [
            'title' => 'Create Product',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/products/create', $data);
    }

    // Save new product
    public function store()
    {
        // Validation rules
        $rules = [
            'fld_title' => 'required|min_length[3]|max_length[100]',
            'fld_description' => 'required|min_length[10]',
            'fld_pricing' => 'required|decimal',
            'fld_market_cap_focus' => 'required|max_length[50]',
            'fld_no_of_ideas' => 'required|max_length[20]',
            'fld_holding_period' => 'required|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Create slug from title
        $slug = url_title($this->request->getVar('fld_title'), '-', true);

        // Save product
        $productData = [
            'fld_title' => $this->request->getVar('fld_title'),
            'fld_slug' => $slug,
            'fld_description' => $this->request->getVar('fld_description'),
            'fld_video_url' => $this->request->getVar('fld_video_url'),
            'fld_research_framework' => $this->request->getVar('fld_research_framework'),
            'fld_market_cap_focus' => $this->request->getVar('fld_market_cap_focus'),
            'fld_no_of_ideas' => $this->request->getVar('fld_no_of_ideas'),
            'fld_holding_period' => $this->request->getVar('fld_holding_period'),
            'fld_pricing' => $this->request->getVar('fld_pricing'),
            'fld_status' => $this->request->getVar('fld_status') ? 1 : 0
        ];

        $productId = $this->productModel->insert($productData);

        // Handle product features
        if ($this->request->getVar('feature_titles')) {
            $featureTitles = $this->request->getVar('feature_titles');
            $featureDescriptions = $this->request->getVar('feature_descriptions');
            
            foreach ($featureTitles as $key => $title) {
                if (!empty($title)) {
                    $featureData = [
                        'fld_product_id' => $productId,
                        'fld_title' => $title,
                        'fld_description' => $featureDescriptions[$key] ?? '',
                        'fld_status' => 1
                    ];
                    
                    // Handle feature image upload
                    $featureImage = $this->request->getFile('feature_images_' . $key);
                    if ($featureImage && $featureImage->isValid() && !$featureImage->hasMoved()) {
                        $newName = $featureImage->getName();
                        $featureImage->move(FCPATH . 'uploads/products/features', $newName);
                        $featureData['fld_image'] = 'uploads/products/features/' . $newName;
                    }
                    
                    $this->productFeatureModel->insert($featureData);
                }
            }
        }

        // Handle app images
        if ($this->request->getFiles('app_images')) {
            $appImages = $this->request->getFiles('app_images');
            foreach ($appImages['app_images'] as $key => $image) {
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getName();
                    $image->move(FCPATH . 'uploads/products/app_images', $newName);
                    
                    $imageData = [
                        'fld_product_id' => $productId,
                        'fld_image' => 'uploads/products/app_images/' . $newName,
                        'fld_display_order' => $key
                    ];
                    
                    $this->appImageModel->insert($imageData);
                }
            }
        }

        return redirect()->to('/admin/products')->with('success', 'Product created successfully');
    }

    // Show edit product form
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        // Get all products except the current one for the copy modal
        $allProductsExceptCurrent = $this->productModel->where('id !=', $id)->findAll();

        $dashboardScuttlebutt = $this->dashboardScuttlebuttModel->getByProductId($id);

        $data = [
            'product' => $product,
            'features' => $this->productFeatureModel->where('fld_product_id', $id)->findAll(),
            'appImages' => $this->appImageModel->where('fld_product_id', $id)->orderBy('fld_display_order', 'ASC')->findAll(),
            'portfolioOverview' => $this->portfolioOverviewModel->where('fld_product_id', $id)->first(),
            'portfolioDistributions' => $this->portfolioDistributionModel->where('fld_product_id', $id)->findAll(),
            'quarterlyUpdates' => $this->quarterlyUpdateModel->where('fld_product_id', $id)->findAll(),
            'managementInterviews' => $this->managementInterviewModel->where('fld_product_id', $id)->findAll(),
            'stocks' => $this->stockModel->getStocksByProduct($id),
            'stockUpdates' => $this->stockUpdateModel->getStockUpdatesWithNames($id),
            'rebalanceTimelines' => $this->rebalanceTimelineModel->where('fld_product_id', $id)->findAll(),
            'scuttlebuttNotes' => $this->scuttlebuttNotesModel->where('fld_product_id', $id)->findAll(),
            'allProductsExceptCurrent' => $allProductsExceptCurrent,
            'dashboardScuttlebutt' => $dashboardScuttlebutt,
            'title' => 'Edit Product',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/products/edit', $data);
    }

    public function update($id)
    {
        // Validation rules
        $rules = [
            'fld_title' => 'required|min_length[3]|max_length[100]',
            'fld_description' => 'required|min_length[10]',
            'fld_pricing' => 'required|decimal',
            'fld_market_cap_focus' => 'required|max_length[50]',
            'fld_no_of_ideas' => 'required|max_length[20]',
            'fld_holding_period' => 'required|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Update product basic details
        $productData = [
            'fld_title' => $this->request->getVar('fld_title'),
            'fld_description' => $this->request->getVar('fld_description'),
            'fld_description_paid' => $this->request->getVar('fld_description_paid'),
            'fld_video_url' => $this->request->getVar('fld_video_url'),
            'fld_how_to_use_url' => $this->request->getVar('fld_how_to_use_url'),
            'fld_research_framework' => $this->request->getVar('fld_research_framework'),
            'fld_market_cap_focus' => $this->request->getVar('fld_market_cap_focus'),
            'fld_no_of_ideas' => $this->request->getVar('fld_no_of_ideas'),
            'fld_holding_period' => $this->request->getVar('fld_holding_period'),
            'fld_minimum_investment' => $this->request->getVar('fld_minimum_investment'),
            'fld_rebalance_frequency' => $this->request->getVar('fld_rebalance_frequency'),
            'fld_next_rebalance' => $this->request->getVar('fld_next_rebalance'),
            'fld_pricing' => $this->request->getVar('fld_pricing'),
            'fld_status' => $this->request->getVar('fld_status') ? 1 : 0
        ];

        $this->productModel->update($id, $productData);

        // Handle product features update
        // Get existing features for this product
        $existingFeatures = $this->productFeatureModel->where('fld_product_id', $id)->findAll();
        $existingFeaturesMap = [];
        foreach ($existingFeatures as $feature) {
            $existingFeaturesMap[$feature['id']] = $feature;
        }
        
        // Process features from form
        $featureTitles = $this->request->getVar('feature_titles') ?? [];
        $featureDescriptions = $this->request->getVar('feature_descriptions') ?? [];
        $processedFeatureIds = [];
        
        foreach ($featureTitles as $key => $title) {
            if (!empty($title)) {
                // Check if this is an existing feature or a new one
                $featureId = $this->request->getVar('feature_ids')[$key] ?? null;
                
                $featureData = [
                    'fld_product_id' => $id,
                    'fld_title' => $title,
                    'fld_description' => $featureDescriptions[$key] ?? '',
                    'fld_status' => 1
                ];
                
                // Handle feature image upload
                $featureImage = $this->request->getFile('feature_images_' . $key);
                if ($featureImage && $featureImage->isValid() && !$featureImage->hasMoved()) {
                    $newName = $featureImage->getName();
                    $featureImage->move(FCPATH . 'uploads/products/features', $newName);
                    $featureData['fld_image'] = 'uploads/products/features/' . $newName;
                } else if ($featureId && isset($existingFeaturesMap[$featureId])) {
                    // Keep existing image if no new image is uploaded
                    $featureData['fld_image'] = $existingFeaturesMap[$featureId]['fld_image'];
                }
                
                if ($featureId && isset($existingFeaturesMap[$featureId])) {
                    // Update existing feature
                    $this->productFeatureModel->update($featureId, $featureData);
                    $processedFeatureIds[] = $featureId;
                } else {
                    // Insert new feature
                    $newFeatureId = $this->productFeatureModel->insert($featureData);
                    $processedFeatureIds[] = $newFeatureId;
                }
            }
        }
        
        // Delete features that were removed from the form
        foreach ($existingFeatures as $feature) {
            if (!in_array($feature['id'], $processedFeatureIds)) {
                $this->productFeatureModel->delete($feature['id']);
            }
        }

        // Handle app images update
        // Get existing image IDs to keep
        $existingImageIds = $this->request->getVar('existing_app_images') ?? [];
        
        // Delete images not in the existing list
        if (!empty($existingImageIds)) {
            $this->appImageModel->where('fld_product_id', $id)
                                ->whereNotIn('id', $existingImageIds)
                                ->delete();
        } else {
            // If no existing images selected, delete all
            $this->appImageModel->where('fld_product_id', $id)->delete();
        }
        
        // Handle new image uploads
        $appImages = $this->request->getFiles('app_images');
        if (isset($appImages['app_images'])) {
            // Get current count of images for this product
            $currentImageCount = $this->appImageModel->where('fld_product_id', $id)->countAllResults();
            
            foreach ($appImages['app_images'] as $image) {
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getName();
                    $image->move(FCPATH . 'uploads/products/app_images', $newName);
                    
                    $imageData = [
                        'fld_product_id' => $id,
                        'fld_image' => 'uploads/products/app_images/' . $newName,
                        'fld_display_order' => $currentImageCount + 1
                    ];
                    
                    $this->appImageModel->insert($imageData);
                    $currentImageCount++;
                }
            }
        }

        // Handle portfolio overview update
        $portfolioData = $this->request->getVar('portfolio');
        if ($portfolioData) {
            $existingOverview = $this->portfolioOverviewModel->where('fld_product_id', $id)->first();
            
            $overviewData = [
                'fld_product_id' => $id,
                'fld_stocks_count' => $portfolioData['stocks_count'] ?? null,
                'fld_last_recommendation_date' => $portfolioData['last_recommendation_date'] ?? null,
                'fld_top_sectors' => $portfolioData['top_sectors'] ?? null,
                'fld_upcoming_review' => $portfolioData['upcoming_review'] ?? null,
                'fld_average_market_cap' => $portfolioData['average_market_cap'] ?? null,
                'fld_dependency_on_us_economy' => $portfolioData['dependency_on_us_economy'] ?? null,
                'fld_disclaimer' => $portfolioData['disclaimer'] ?? null
            ];
            
            if ($existingOverview) {
                $this->portfolioOverviewModel->update($existingOverview['id'], $overviewData);
            } else {
                $this->portfolioOverviewModel->insert($overviewData);
            }
        }

        // Handle portfolio distribution update
        // First, delete all existing distributions for this product
        $this->portfolioDistributionModel->where('fld_product_id', $id)->delete();
        
        // Then add new distributions
        $distributionCategories = $this->request->getVar('distribution[category]') ?? [];
        $distributionPercentages = $this->request->getVar('distribution[percentage]') ?? [];
        
        foreach ($distributionCategories as $key => $category) {
            if (!empty($category) && isset($distributionPercentages[$key])) {
                $distributionData = [
                    'fld_product_id' => $id,
                    'fld_category' => $category,
                    'fld_percentage' => $distributionPercentages[$key]
                ];
                
                $this->portfolioDistributionModel->insert($distributionData);
            }
        }

        // Handle quarterly updates
        // First, delete all existing updates for this product
        $this->quarterlyUpdateModel->where('fld_product_id', $id)->delete();
        
        // Then add new updates
        $quarterlyTitles = $this->request->getVar('quarterly_updates[title]') ?? [];
        $quarterlyVideoUrls = $this->request->getVar('quarterly_updates[video_url]') ?? [];
        $quarterlyDescriptions = $this->request->getVar('quarterly_updates[description]') ?? [];
        
        foreach ($quarterlyTitles as $key => $title) {
            if (!empty($title)) {
                $updateData = [
                    'fld_product_id' => $id,
                    'fld_title' => $title,
                    'fld_video_url' => $quarterlyVideoUrls[$key] ?? null,
                    'fld_description' => $quarterlyDescriptions[$key] ?? null
                ];
                
                $this->quarterlyUpdateModel->insert($updateData);
            }
        }

        // Handle management interviews
        // First, delete all existing interviews for this product
        $this->managementInterviewModel->where('fld_product_id', $id)->delete();
        
        // Then add new interviews
        $interviewTitles = $this->request->getVar('interviews[title]') ?? [];
        $interviewVideoUrls = $this->request->getVar('interviews[video_url]') ?? [];
        $interviewDescriptions = $this->request->getVar('interviews[description]') ?? [];
        
        foreach ($interviewTitles as $key => $title) {
            if (!empty($title)) {
                $interviewData = [
                    'fld_product_id' => $id,
                    'fld_title' => $title,
                    'fld_video_url' => $interviewVideoUrls[$key] ?? null,
                    'fld_description' => $interviewDescriptions[$key] ?? null
                ];
                
                $this->managementInterviewModel->insert($interviewData);
            }
        }

        // Handle stocks update
        // Instead of deleting all stocks, we'll update existing ones and add new ones
        $existingStockIds = [];
        $stockNames = $this->request->getVar('stocks[name]') ?? [];
        $stockIds = $this->request->getVar('stocks[id]') ?? [];
        $stockDates = $this->request->getVar('stocks[date]') ?? [];
        $stockPrices = $this->request->getVar('stocks[price]') ?? [];
        $stockCmps = $this->request->getVar('stocks[cmp]') ?? [];
        $stockReturns = $this->request->getVar('stocks[returns]') ?? [];
        $stockAllocations = $this->request->getVar('stocks[allocation]') ?? [];
        $stockActions = $this->request->getVar('stocks[action]') ?? [];
        $stockSectors = $this->request->getVar('stocks[sector]') ?? [];
        $stockRatings = $this->request->getVar('stocks[rating]') ?? [];

        foreach ($stockNames as $key => $name) {
            if (!empty($name)) {
                $stockData = [
                    'fld_product_id' => $id,
                    'fld_stock_name' => $name,
                    'fld_date_of_recommendation' => $stockDates[$key] ?? null,
                    'fld_price_at_recommendation' => $stockPrices[$key] ?? null,
                    'fld_cmp' => $stockCmps[$key] ?? null,
                    'fld_returns' => $stockReturns[$key] ?? null,
                    'fld_allocation' => $stockAllocations[$key] ?? null,
                    'fld_action' => $stockActions[$key] ?? null,
                    'fld_sector' => $stockSectors[$key] ?? null,
                    'fld_rating' => $stockRatings[$key] ?? null,
                    'fld_status' => 1
                ];
                
                // Handle report file upload
                $reportFiles = $this->request->getFileMultiple('stocks_report');
                if ($reportFiles && isset($reportFiles[$key])) {
                    $reportFile = $reportFiles[$key];
                    if ($reportFile && $reportFile->isValid() && !$reportFile->hasMoved()) {
                        $newName = $reportFile->getName();
                        $reportFile->move(FCPATH . 'uploads/stocks/reports', $newName);
                        $stockData['fld_report_url'] = 'uploads/stocks/reports/' . $newName;
                    }
                } else if (isset($stockIds[$key]) && !empty($stockIds[$key])) {
                    // Keep existing report if no new file is uploaded
                    $existingStock = $this->stockModel->find($stockIds[$key]);
                    if ($existingStock && !empty($existingStock['fld_report_url'])) {
                        $stockData['fld_report_url'] = $existingStock['fld_report_url'];
                    }
                }
                
                // Check if this is an existing stock or a new one
                if (isset($stockIds[$key]) && !empty($stockIds[$key])) {
                    // Update existing stock
                    $this->stockModel->update($stockIds[$key], $stockData);
                    $existingStockIds[] = $stockIds[$key];
                } else {
                    // Insert new stock
                    $newStockId = $this->stockModel->insert($stockData);
                    $existingStockIds[] = $newStockId;
                }
            }
        }

        // Delete stocks that were removed from the form
        if (!empty($existingStockIds)) {
            $this->stockModel->where('fld_product_id', $id)
                            ->whereNotIn('id', $existingStockIds)
                            ->delete();
        } else {
            // If no stocks exist, delete all for this product
            $this->stockModel->where('fld_product_id', $id)->delete();
        }

        // Handle stock updates update
        // Instead of deleting all stock updates, we'll update existing ones and add new ones
        $existingUpdateIds = [];
        $updateIds = $this->request->getVar('stock_updates[id]') ?? [];
        $updateStockIds = $this->request->getVar('stock_updates[stock]') ?? [];
        $updateDates = $this->request->getVar('stock_updates[date]') ?? [];
        $updateDescriptions = $this->request->getVar('stock_updates[description]') ?? [];

        foreach ($updateStockIds as $key => $stockId) {
            if (!empty($stockId) && !empty($updateDates[$key])) {
                $updateData = [
                    'fld_product_id' => $id,
                    'fld_stock_id' => $stockId,
                    'fld_update_date' => $updateDates[$key],
                    'fld_description' => $updateDescriptions[$key] ?? null,
                    'fld_status' => 1
                ];
                
                // Check if this is an existing update or a new one
                if (isset($updateIds[$key]) && !empty($updateIds[$key])) {
                    // Update existing update
                    $this->stockUpdateModel->update($updateIds[$key], $updateData);
                    $existingUpdateIds[] = $updateIds[$key];
                } else {
                    // Insert new update
                    $newUpdateId = $this->stockUpdateModel->insert($updateData);
                    $existingUpdateIds[] = $newUpdateId;
                }
            }
        }

        // Delete stock updates that were removed from the form
        if (!empty($existingUpdateIds)) {
            $this->stockUpdateModel->where('fld_product_id', $id)
                                ->whereNotIn('id', $existingUpdateIds)
                                ->delete();
        } else {
            // If no updates exist, delete all for this product
            $this->stockUpdateModel->where('fld_product_id', $id)->delete();
        }

        // Handle rebalance timelines
        // Instead of deleting all rebalance timelines, we'll update existing ones and add new ones
        $existingRebalanceIds = [];
        $rebalanceIds = $this->request->getVar('rebalance[id]') ?? [];
        $rebalanceDates = $this->request->getVar('rebalance[date]') ?? [];
        $rebalanceConstituentsPlus = $this->request->getVar('rebalance[constituents_plus]') ?? [];
        $rebalanceConstituentsMinus = $this->request->getVar('rebalance[constituents_minus]') ?? [];
        $rebalanceDescriptions = $this->request->getVar('rebalance[description]') ?? [];

        foreach ($rebalanceDates as $key => $date) {
            if (!empty($date)) {
                $rebalanceData = [
                    'fld_product_id' => $id,
                    'fld_date' => $date,
                    'fld_constituents_plus' => $rebalanceConstituentsPlus[$key] ?? null,
                    'fld_constituents_minus' => $rebalanceConstituentsMinus[$key] ?? null,
                    'fld_description' => $rebalanceDescriptions[$key] ?? null,
                    'fld_status' => 1
                ];
                
                // Handle factsheet file upload - FIXED
                $factsheetFiles = $this->request->getFileMultiple('rebalance_factsheet');
                if ($factsheetFiles && isset($factsheetFiles[$key])) {
                    $factsheetFile = $factsheetFiles[$key];
                    if ($factsheetFile && $factsheetFile->isValid() && !$factsheetFile->hasMoved()) {
                        $newName = $factsheetFile->getName();
                        $factsheetFile->move(FCPATH . 'uploads/rebalance/factsheets', $newName);
                        $rebalanceData['fld_factsheet_url'] = 'uploads/rebalance/factsheets/' . $newName;
                    }
                } else if (isset($rebalanceIds[$key]) && !empty($rebalanceIds[$key])) {
                    // Keep existing factsheet if no new file is uploaded
                    $existingRebalance = $this->rebalanceTimelineModel->find($rebalanceIds[$key]);
                    if ($existingRebalance && !empty($existingRebalance['fld_factsheet_url'])) {
                        $rebalanceData['fld_factsheet_url'] = $existingRebalance['fld_factsheet_url'];
                    }
                }
                
                // Check if this is an existing rebalance or a new one
                if (isset($rebalanceIds[$key]) && !empty($rebalanceIds[$key])) {
                    // Update existing rebalance
                    $this->rebalanceTimelineModel->update($rebalanceIds[$key], $rebalanceData);
                    $existingRebalanceIds[] = $rebalanceIds[$key];
                } else {
                    // Insert new rebalance
                    $newRebalanceId = $this->rebalanceTimelineModel->insert($rebalanceData);
                    $existingRebalanceIds[] = $newRebalanceId;
                }
            }
        }

        // Delete rebalance timelines that were removed from the form
        if (!empty($existingRebalanceIds)) {
            $this->rebalanceTimelineModel->where('fld_product_id', $id)
                                        ->whereNotIn('id', $existingRebalanceIds)
                                        ->delete();
        } else {
            // If no rebalances exist, delete all for this product
            $this->rebalanceTimelineModel->where('fld_product_id', $id)->delete();
        }

        // Handle scuttlebutt notes
        // Instead of deleting all scuttlebutt notes, we'll update existing ones and add new ones
        $existingScuttlebuttIds = [];
        $scuttlebuttIds = $this->request->getVar('scuttlebutt[id]') ?? [];
        $scuttlebuttTitles = $this->request->getVar('scuttlebutt[title]') ?? [];
        $scuttlebuttDates = $this->request->getVar('scuttlebutt[date]') ?? [];
        $scuttlebuttDescriptions = $this->request->getVar('scuttlebutt[description]') ?? [];

        foreach ($scuttlebuttTitles as $key => $title) {
            if (!empty($title)) {
                $scuttlebuttData = [
                    'fld_product_id' => $id,
                    'fld_title' => $title,
                    'fld_date' => $scuttlebuttDates[$key] ?? null,
                    'fld_description' => $scuttlebuttDescriptions[$key] ?? null,
                    'fld_status' => 1
                ];
                
                // Check if this is an existing scuttlebutt note or a new one
                if (isset($scuttlebuttIds[$key]) && !empty($scuttlebuttIds[$key])) {
                    // Update existing scuttlebutt note
                    $this->scuttlebuttNotesModel->update($scuttlebuttIds[$key], $scuttlebuttData);
                    $existingScuttlebuttIds[] = $scuttlebuttIds[$key];
                } else {
                    // Insert new scuttlebutt note
                    $newScuttlebuttId = $this->scuttlebuttNotesModel->insert($scuttlebuttData);
                    $existingScuttlebuttIds[] = $newScuttlebuttId;
                }
            }
        }

        // Delete scuttlebutt notes that were removed from the form
        if (!empty($existingScuttlebuttIds)) {
            $this->scuttlebuttNotesModel->where('fld_product_id', $id)
                                        ->whereNotIn('id', $existingScuttlebuttIds)
                                        ->delete();
        } else {
            // If no scuttlebutt notes exist, delete all for this product
            $this->scuttlebuttNotesModel->where('fld_product_id', $id)->delete();
        }

        // Handle dashboard scuttlebutt update
        $dashboardScuttlebutt = $this->dashboardScuttlebuttModel->getByProductId($id);
        $dashboardScuttlebuttData = [
            'fld_updated_date' => $this->request->getVar('dashboard_scuttlebutt[updated_date]') ?? null,
            'fld_description' => $this->request->getVar('dashboard_scuttlebutt[description]') ?? null,
            'fld_status' => 1
        ];

        // Handle dashboard scuttlebutt image upload
        $dashboardImage = $this->request->getFile('dashboard_scuttlebutt_image');
        if ($dashboardImage && $dashboardImage->isValid() && !$dashboardImage->hasMoved()) {
            $newName = $dashboardImage->getName();
            $dashboardImage->move(FCPATH . 'uploads/products/dashboard_scuttlebutt', $newName);
            $dashboardScuttlebuttData['fld_image'] = 'uploads/products/dashboard_scuttlebutt/' . $newName;
        } else if ($dashboardScuttlebutt) {
            // Keep existing image if no new image is uploaded
            $dashboardScuttlebuttData['fld_image'] = $dashboardScuttlebutt['fld_image'];
        }

        // Save or update dashboard scuttlebutt
        $this->dashboardScuttlebuttModel->saveDashboardScuttlebutt($id, $dashboardScuttlebuttData);

        return redirect()->to('/admin/products')->with('success', 'Product updated successfully');
    }

    // Delete product
    public function delete($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        // Delete related records
        $this->productFeatureModel->where('fld_product_id', $id)->delete();
        $this->appImageModel->where('fld_product_id', $id)->delete();
        $this->portfolioOverviewModel->where('fld_product_id', $id)->delete();
        $this->portfolioDistributionModel->where('fld_product_id', $id)->delete();
        $this->quarterlyUpdateModel->where('fld_product_id', $id)->delete();
        $this->managementInterviewModel->where('fld_product_id', $id)->delete();
        $this->stockModel->where('fld_product_id', $id)->delete();
        $this->stockUpdateModel->where('fld_product_id', $id)->delete();
        $this->rebalanceTimelineModel->where('fld_product_id', $id)->delete();
        $this->scuttlebuttNotesModel->where('fld_product_id', $id)->delete();

        // Delete product
        $this->productModel->delete($id);

        return redirect()->to('/admin/products')->with('success', 'Product deleted successfully');
    }

    public function copyInterview()
    {
        $interviewId = $this->request->getPost('interview_id');
        $targetProductId = $this->request->getPost('target_product_id');

        if (!$interviewId || !$targetProductId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing required parameters'
            ]);
        }

        // Get the original interview
        $originalInterview = $this->managementInterviewModel->find($interviewId);
        if (!$originalInterview) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Interview not found'
            ]);
        }

        // Check if target product already has an interview with the same title
        $existingInterview = $this->managementInterviewModel
            ->where('fld_product_id', $targetProductId)
            ->where('fld_title', $originalInterview['fld_title'])
            ->first();

        if ($existingInterview) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An interview with the title "' . $originalInterview['fld_title'] . '" already exists in the target product'
            ]);
        }

        // Prepare data for the new interview
        $newInterviewData = [
            'fld_product_id' => $targetProductId,
            'fld_title' => $originalInterview['fld_title'],
            'fld_video_url' => $originalInterview['fld_video_url'],
            'fld_description' => $originalInterview['fld_description'],            
        ];

        // Insert the new interview
        $newInterviewId = $this->managementInterviewModel->insert($newInterviewData);

        if ($newInterviewId) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Interview copied successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to copy interview'
            ]);
        }
    }

    public function copyScuttlebutt()
    {
        $scuttlebuttId = $this->request->getPost('scuttlebutt_id');
        $targetProductId = $this->request->getPost('target_product_id');
        $copyAll = $this->request->getPost('copy_all');
        $replaceOption = $this->request->getPost('replace_option');

        if (!$targetProductId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Target product is required'
            ]);
        }

        // Check if target product already has scuttlebutt notes
        $existingNotes = $this->scuttlebuttNotesModel->where('fld_product_id', $targetProductId)->findAll();
        $hasExistingNotes = !empty($existingNotes);

        $copiedCount = 0;

        if ($copyAll == '1') {
            // Copy ALL scuttlebutt notes from current product
            $currentProductId = $this->request->getPost('current_product_id');
            $allNotes = $this->scuttlebuttNotesModel->where('fld_product_id', $currentProductId)->findAll();
            
            // Only delete existing notes if user wants to replace ALL notes
            if ($hasExistingNotes && $replaceOption === 'replace') {
                $this->scuttlebuttNotesModel->where('fld_product_id', $targetProductId)->delete();
            }
            
            foreach ($allNotes as $note) {
                // Check if a note with the same title already exists (only if adding to existing)
                if ($hasExistingNotes && $replaceOption === 'add') {
                    $existingNote = $this->scuttlebuttNotesModel
                        ->where('fld_product_id', $targetProductId)
                        ->where('fld_title', $note['fld_title'])
                        ->first();
                    
                    if ($existingNote) {
                        continue; // Skip this note if it already exists
                    }
                }
                
                $newNoteData = [
                    'fld_product_id' => $targetProductId,
                    'fld_title' => $note['fld_title'],
                    'fld_date' => $note['fld_date'],
                    'fld_description' => $note['fld_description'],
                    'fld_status' => 1
                ];
                
                $this->scuttlebuttNotesModel->insert($newNoteData);
                $copiedCount++;
            }
        } else {
            // Copy a SINGLE scuttlebutt note
            $originalNote = $this->scuttlebuttNotesModel->find($scuttlebuttId);
            if (!$originalNote) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Scuttlebutt note not found'
                ]);
            }

            // Check if target product already has a note with the same title
            $existingNote = $this->scuttlebuttNotesModel
                ->where('fld_product_id', $targetProductId)
                ->where('fld_title', $originalNote['fld_title'])
                ->first();

            if ($existingNote) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'A scuttlebutt note with the title "' . $originalNote['fld_title'] . '" already exists in the target product'
                ]);
            }

            // For single note copy, NEVER delete existing notes
            // Just add the new note
            
            // Prepare data for the new note
            $newNoteData = [
                'fld_product_id' => $targetProductId,
                'fld_title' => $originalNote['fld_title'],
                'fld_date' => $originalNote['fld_date'],
                'fld_description' => $originalNote['fld_description'],
                'fld_status' => 1
            ];

            // Insert the new note
            if ($this->scuttlebuttNotesModel->insert($newNoteData)) {
                $copiedCount = 1;
            }
        }

        if ($copiedCount > 0) {
            $message = $copiedCount > 1 ? 
                "$copiedCount scuttlebutt notes copied successfully" : 
                "Scuttlebutt note copied successfully";
                
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'copied_count' => $copiedCount
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No notes were copied. They may already exist in the target product.'
            ]);
        }
    }

    public function checkScuttlebuttExists()
    {
        $productId = $this->request->getPost('product_id');
        
        if (!$productId) {
            return $this->response->setJSON(['exists' => false]);
        }
        
        $notes = $this->scuttlebuttNotesModel->where('fld_product_id', $productId)->findAll();
        
        return $this->response->setJSON(['exists' => !empty($notes)]);
    }
}