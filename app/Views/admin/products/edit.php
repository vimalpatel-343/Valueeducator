<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-white">Edit Product: <?= $product['fld_title'] ?></h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data" id="productForm">
                        <!-- Classic Tab Navigation -->
                        <ul class="nav nav-tabs classic-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basic-tab" data-bs-toggle="tab" href="#basic-details" role="tab" aria-controls="basic-details" aria-selected="true">
                                    <i class="bx bx-info-circle me-2"></i>Basic Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="stocks-tab" data-bs-toggle="tab" href="#stocks" role="tab" aria-controls="stocks" aria-selected="false">
                                    <i class="bx bx-line-chart me-2"></i>Stocks
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="portfolio-tab" data-bs-toggle="tab" href="#portfolio" role="tab" aria-controls="portfolio" aria-selected="false">
                                    <i class="bx bx-pie-chart-alt-2 me-2"></i>Portfolio
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="updates-tab" data-bs-toggle="tab" href="#updates" role="tab" aria-controls="updates" aria-selected="false">
                                    <i class="bx bx-refresh me-2"></i>Updates
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Tab Content -->
                        <div class="tab-content p-3" id="myTabContent">
                            <!-- Basic Details Tab -->
                            <div class="tab-pane fade show active" id="basic-details" role="tabpanel" aria-labelledby="basic-tab">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Product Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Product Title <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_title" value="<?= $product['fld_title'] ?>" required>
                                                <?php if ($validation->getError('fld_title')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_title') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Description (For Non Paid User) <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" id="fld_description" name="fld_description" rows="5"><?= $product['fld_description'] ?></textarea>
                                                <?php if ($validation->getError('fld_description')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_description') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Description (For Paid User) <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" id="fld_description_paid" name="fld_description_paid" rows="5"><?= $product['fld_description_paid'] ?></textarea>
                                                <?php if ($validation->getError('fld_description_paid')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_description_paid') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Video URL</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_video_url" value="<?= $product['fld_video_url'] ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">How to use?</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_how_to_use_url" value="<?= $product['fld_how_to_use_url'] ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Research Framework</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" name="fld_research_framework" rows="2"><?= $product['fld_research_framework'] ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Market Cap Focus <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_market_cap_focus" value="<?= $product['fld_market_cap_focus'] ?>" required>
                                                <?php if ($validation->getError('fld_market_cap_focus')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_market_cap_focus') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">No. of Ideas/Year <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_no_of_ideas" value="<?= $product['fld_no_of_ideas'] ?>" required>
                                                <?php if ($validation->getError('fld_no_of_ideas')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_no_of_ideas') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Holding Period <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_holding_period" value="<?= $product['fld_holding_period'] ?>" required>
                                                <?php if ($validation->getError('fld_holding_period')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_holding_period') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Minimum Investment</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_minimum_investment" value="<?= $product['fld_minimum_investment'] ?>">
                                                <?php if ($validation->getError('fld_minimum_investment')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_minimum_investment') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Rebalance Frequency</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_rebalance_frequency" value="<?= $product['fld_rebalance_frequency'] ?>">
                                                <?php if ($validation->getError('fld_rebalance_frequency')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_rebalance_frequency') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Next Rebalance</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="fld_next_rebalance" value="<?= $product['fld_next_rebalance'] ?>">
                                                <?php if ($validation->getError('fld_next_rebalance')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_next_rebalance') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Pricing (₹) <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" name="fld_pricing" value="<?= $product['fld_pricing'] ?>" step="0.01" required>
                                                <?php if ($validation->getError('fld_pricing')): ?>
                                                    <div class="text-danger"><?= $validation->getError('fld_pricing') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Status</label>
                                            <div class="col-md-9">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="fld_status" id="fld_status" <?= $product['fld_status'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="fld_status">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Product Features Section -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Product Features</h5>
                                        <button type="button" class="btn btn-primary btn-sm" id="addFeatureBtn">
                                            <i class="bx bx-plus me-1"></i> Add Feature
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="featuresContainer">
                                            <?php foreach ($features as $index => $feature): ?>
                                            <div class="feature-item card mb-3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label">Feature Title</label>
                                                            <input type="hidden" name="feature_ids[]" value="<?= $feature['id'] ?>">
                                                            <input type="text" class="form-control" name="feature_titles[]" value="<?= $feature['fld_title'] ?>" required>
                                                        </div>
                                                        <div class="col-md-7 mb-3">
                                                            <label class="form-label">Feature Description</label>
                                                            <textarea class="form-control feature-description" name="feature_descriptions[]" rows="5"><?= $feature['fld_description'] ?></textarea>
                                                        </div>
                                                        <div class="col-md-2 mb-3">
                                                            <label class="form-label">Image</label>
                                                            <input type="file" class="form-control" name="feature_images_<?= $index ?>" accept="image/*">
                                                            <?php if ($feature['fld_image']): ?>
                                                                <img src="<?= base_url($feature['fld_image']) ?>" class="img-thumbnail mt-1" style="max-height: 50px;">
                                                            <?php endif; ?>
                                                            <button type="button" class="btn btn-danger btn-sm mt-1 remove-feature w-100">
                                                                <i class="bx bx-trash"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- App Images Section -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">App Images (Max 5)</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                            <div class="col-md-3 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <div class="app-image-preview mb-2">
                                                            <?php if (isset($appImages[$i])): ?>
                                                                <img src="<?= base_url($appImages[$i]['fld_image']) ?>" class="img-fluid" alt="App Image">
                                                            <?php else: ?>
                                                                <img src="<?= base_url('assets/img/no-image.png') ?>" class="img-fluid" alt="App Image">
                                                            <?php endif; ?>
                                                        </div>
                                                        <input type="file" class="form-control" name="app_images[]" accept="image/*">
                                                        <?php if (isset($appImages[$i])): ?>
                                                            <input type="hidden" name="existing_app_images[]" value="<?= $appImages[$i]['id'] ?>">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Stocks Tab -->
                            <div class="tab-pane fade" id="stocks" role="tabpanel" aria-labelledby="stocks-tab">
                                
                                <!-- Model Portfolio Stocks Section -->
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center p-3">
                                        <h5 class="mb-0 text-white"><i class="bx bx-line-chart me-2"></i>Model Portfolio Stocks</h5>
                                        <button type="button" class="btn btn-light btn-sm" id="addStockBtn">
                                            <i class="bx bx-plus me-1"></i> Add New Stock
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion" id="stocksAccordion">
                                            <?php if (!empty($stocks)): ?>
                                                <?php foreach ($stocks as $index => $stock): ?>
                                                <div class="accordion-item stock-item mb-3">
                                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                                        <div class="d-flex align-items-center">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                                    <span><i class="bx bx-buildings me-2"></i> <?= $stock['fld_stock_name'] ?></span>
                                                                    <span class="badge bg-<?= $stock['fld_action'] == 'Buy' ? 'success' : 'danger' ?> me-3"><?= $stock['fld_action'] ?></span>
                                                                </div>
                                                            </button>
                                                            <div class="dropdown ms-2">
                                                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item remove-stock" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </h2>
                                                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>">
                                                        <div class="accordion-body">
                                                            <input type="hidden" name="stocks[id][]" value="<?= $stock['id'] ?>">
                                                            
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Stock Name</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                                                        <input type="text" class="form-control" name="stocks[name][]" value="<?= $stock['fld_stock_name'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Date of Recommendation</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                                        <input type="date" class="form-control" name="stocks[date][]" value="<?= $stock['fld_date_of_recommendation'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">Price (₹)</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">₹</span>
                                                                        <input type="number" class="form-control" name="stocks[price][]" value="<?= $stock['fld_price_at_recommendation'] ?>" step="0.01" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">CMP (₹)</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">₹</span>
                                                                        <input type="number" class="form-control" name="stocks[cmp][]" value="<?= $stock['fld_cmp'] ?>" step="0.01">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">Returns (%)</label>
                                                                    <div class="input-group">
                                                                        <input type="number" class="form-control" name="stocks[returns][]" value="<?= $stock['fld_returns'] ?>" step="0.01">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">Allocation (%)</label>
                                                                    <div class="input-group">
                                                                        <input type="number" class="form-control" name="stocks[allocation][]" value="<?= $stock['fld_allocation'] ?>" step="0.01" required>
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">Action</label>
                                                                    <select class="form-select" name="stocks[action][]" required>
                                                                        <option value="">Select</option>
                                                                        <option value="Buy" <?= $stock['fld_action'] == 'Buy' ? 'selected' : '' ?>>Buy</option>
                                                                        <option value="Sell" <?= $stock['fld_action'] == 'Sell' ? 'selected' : '' ?>>Sell</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">Sector</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="bx bx-category"></i></span>
                                                                        <input type="text" class="form-control" name="stocks[sector][]" value="<?= $stock['fld_sector'] ?>" >
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">Rating</label>
                                                                    <select class="form-select" name="stocks[rating][]" >
                                                                        <option value="">Rating</option>
                                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                        <option value="<?= $i ?>" <?= $stock['fld_rating'] == $i ? 'selected' : '' ?>>
                                                                            <?= $i ?> Star<?= $i > 1 ? 's' : '' ?>
                                                                        </option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <label class="form-label small text-muted">Report</label>
                                                                    <?php if ($stock['fld_report_url']): ?>
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <a href="<?= base_url($stock['fld_report_url']) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                                                <i class="bx bx-file me-1"></i> View Report
                                                                            </a>
                                                                            <input type="hidden" name="stocks[existing_report][]" value="<?= $stock['fld_report_url'] ?>">
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <input type="file" class="form-control form-control-sm" name="stocks_report[]" accept=".pdf,.doc,.docx">
                                                                </div>
                                                                
                                                                <div class="col-12 mt-3">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="stock-summary">
                                                                            <span class="badge bg-secondary me-2">Sector: <?= $stock['fld_sector'] ?></span>
                                                                            <span class="badge bg-info me-2">Rating: <?= $stock['fld_rating'] ?>/5</span>
                                                                            <span class="badge bg-warning text-dark">Allocation: <?= $stock['fld_allocation'] ?>%</span>
                                                                        </div>
                                                                        <div class="stock-performance">
                                                                            <?php if (!empty($stock['fld_cmp']) && !empty($stock['fld_price_at_recommendation'])): ?>
                                                                                <?php 
                                                                                $performance = (($stock['fld_cmp'] - $stock['fld_price_at_recommendation']) / $stock['fld_price_at_recommendation']) * 100;
                                                                                $performanceClass = $performance >= 0 ? 'text-success' : 'text-danger';
                                                                                $performanceIcon = $performance >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt';
                                                                                ?>
                                                                                <span class="<?= $performanceClass ?>">
                                                                                    <i class='bx <?= $performanceIcon ?>'></i> 
                                                                                    <?= number_format(abs($performance), 2) ?>%
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="text-center py-5">
                                                    <i class="bx bx-line-chart fs-1 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No stocks added yet</h5>
                                                    <p class="text-muted">Click "Add New Stock" to add stocks to the portfolio.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Stock Updates Section -->
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center p-3">
                                        <h5 class="mb-0 text-white"><i class="bx bx-refresh me-2"></i>Stock Updates</h5>
                                        <button type="button" class="btn btn-light btn-sm" id="addStockUpdateBtn">
                                            <i class="bx bx-plus me-1"></i> Add New Update
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion" id="stockUpdatesAccordion">
                                            <?php if (!empty($stockUpdates)): ?>
                                                <?php foreach ($stockUpdates as $index => $update): ?>
                                                <div class="accordion-item update-item mb-3">
                                                    <h2 class="accordion-header" id="updateHeading<?= $index ?>">
                                                        <div class="d-flex align-items-center">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#updateCollapse<?= $index ?>" aria-expanded="false" aria-controls="updateCollapse<?= $index ?>">
                                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                                    <span><i class="bx bx-refresh me-2"></i> <?= $update['fld_stock_name'] ?> - <?= date('d M Y', strtotime($update['fld_update_date'])) ?></span>
                                                                </div>
                                                            </button>
                                                            <div class="dropdown ms-2">
                                                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item edit-update" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                                    <li><a class="dropdown-item remove-update" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </h2>
                                                    <div id="updateCollapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="updateHeading<?= $index ?>">
                                                        <div class="accordion-body">
                                                            <input type="hidden" name="stock_updates[id][]" value="<?= $update['id'] ?>">
                                                            
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Stock</label>
                                                                    <select class="form-select" name="stock_updates[stock][]" required>
                                                                        <option value="">Select Stock</option>
                                                                        <?php foreach ($stocks as $stock): ?>
                                                                        <option value="<?= $stock['id'] ?>" <?= $update['fld_stock_id'] == $stock['id'] ? 'selected' : '' ?>>
                                                                            <?= $stock['fld_stock_name'] ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Update Date</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                                        <input type="date" class="form-control" name="stock_updates[date][]" value="<?= $update['fld_update_date'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-12">
                                                                    <label class="form-label small text-muted">Update Description</label>
                                                                    <textarea class="form-control stock-update-editor" name="stock_updates[description][]" rows="5"><?= $update['fld_description'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="text-center py-5">
                                                    <i class="bx bx-refresh fs-1 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No updates added yet</h5>
                                                    <p class="text-muted">Click "Add New Update" to add stock updates.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Portfolio Tab -->
                            <div class="tab-pane fade" id="portfolio" role="tabpanel" aria-labelledby="portfolio-tab">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Portfolio Overview</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Stocks Count</label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" name="portfolio[stocks_count]" value="<?= $portfolioOverview['fld_stocks_count'] ?? '' ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Last Recommendation Date</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" name="portfolio[last_recommendation_date]" value="<?= $portfolioOverview['fld_last_recommendation_date'] ?? '' ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Top Sectors</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="portfolio[top_sectors]" value="<?= $portfolioOverview['fld_top_sectors'] ?? '' ?>">
                                                <small class="text-muted">Enter comma-separated sectors (e.g., Chemical, EV, IT)</small>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Upcoming Review</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="portfolio[upcoming_review]" value="<?= $portfolioOverview['fld_upcoming_review'] ?? '' ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Average Market Cap</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="portfolio[average_market_cap]" value="<?= $portfolioOverview['fld_average_market_cap'] ?? '' ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Dependency on US Economy</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="portfolio[dependency_on_us_economy]">
                                                    <option value="">Select Dependency</option>
                                                    <option value="Low" <?= (isset($portfolioOverview['fld_dependency_on_us_economy']) && $portfolioOverview['fld_dependency_on_us_economy'] == 'Low') ? 'selected' : '' ?>>Low</option>
                                                    <option value="Medium" <?= (isset($portfolioOverview['fld_dependency_on_us_economy']) && $portfolioOverview['fld_dependency_on_us_economy'] == 'Medium') ? 'selected' : '' ?>>Medium</option>
                                                    <option value="High" <?= (isset($portfolioOverview['fld_dependency_on_us_economy']) && $portfolioOverview['fld_dependency_on_us_economy'] == 'High') ? 'selected' : '' ?>>High</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Disclaimer</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" name="portfolio[disclaimer]" rows="3"><?= $portfolioOverview['fld_disclaimer'] ?? '' ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Portfolio Distribution</h5>
                                        <button type="button" class="btn btn-primary btn-sm" id="addDistributionBtn">
                                            <i class="bx bx-plus me-1"></i> Add Distribution
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Percentage (%)</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="distributionTableBody">
                                                    <?php foreach ($portfolioDistributions as $distribution): ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="distribution[category][]" value="<?= $distribution['fld_category'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="distribution[percentage][]" value="<?= $distribution['fld_percentage'] ?>" step="0.01">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm remove-distribution">
                                                                <i class="bx bx-trash"></i> Remove
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php if (empty($portfolioDistributions)): ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            <p class="mb-0">No distribution added yet. Click "Add Distribution" to add portfolio distribution.</p>
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center p-3">
                                        <h5 class="mb-0 text-white"><i class="bx bx-timeline me-2"></i>Rebalance Timeline</h5>
                                        <button type="button" class="btn btn-light btn-sm" id="addRebalanceBtn">
                                            <i class="bx bx-plus me-1"></i> Add Rebalance
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion" id="rebalanceAccordion">
                                            <?php if (!empty($rebalanceTimelines)): ?>
                                                <?php foreach ($rebalanceTimelines as $index => $rebalance): ?>
                                                <div class="accordion-item rebalance-item mb-3">
                                                    <h2 class="accordion-header" id="rebalanceHeading<?= $index ?>">
                                                        <div class="d-flex align-items-center">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rebalanceCollapse<?= $index ?>" aria-expanded="false" aria-controls="rebalanceCollapse<?= $index ?>">
                                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                                    <span><i class="bx bx-timeline me-2"></i> <?= date('d M Y', strtotime($rebalance['fld_date'])) ?></span>
                                                                </div>
                                                            </button>
                                                            <div class="dropdown ms-2">
                                                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item edit-rebalance" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                                    <li><a class="dropdown-item remove-rebalance" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </h2>
                                                    <div id="rebalanceCollapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="rebalanceHeading<?= $index ?>">
                                                        <div class="accordion-body">
                                                            <input type="hidden" name="rebalance[id][]" value="<?= $rebalance['id'] ?>">
                                                            
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Date</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                                        <input type="date" class="form-control" name="rebalance[date][]" value="<?= $rebalance['fld_date'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Constituents Change</label>
                                                                    <div class="d-flex gap-2">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text text-success">+</span>
                                                                            <input type="number" class="form-control"
                                                                                name="rebalance[constituents_plus][]"
                                                                                placeholder="Ex. +1"
                                                                                min="0" value="<?= $rebalance['fld_constituents_plus'] ?>">
                                                                        </div>

                                                                        <div class="input-group">
                                                                            <span class="input-group-text text-danger">−</span>
                                                                            <input type="number" class="form-control"
                                                                                name="rebalance[constituents_minus][]"
                                                                                placeholder="Ex. -1"
                                                                                min="0" value="<?= $rebalance['fld_constituents_minus'] ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Factsheet</label>
                                                                    <?php if ($rebalance['fld_factsheet_url']): ?>
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <a href="<?= base_url($rebalance['fld_factsheet_url']) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                                                <i class="bx bx-file me-1"></i> View Factsheet
                                                                            </a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <input type="file" class="form-control form-control-sm" name="rebalance_factsheet[]" accept=".pdf,.doc,.docx">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Description</label>
                                                                    <textarea class="form-control rebalance-editor" name="rebalance[description][]" rows="5"><?= $rebalance['fld_description'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="text-center py-5">
                                                    <i class="bx bx-timeline fs-1 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No rebalance added yet</h5>
                                                    <p class="text-muted">Click "Add Rebalance" to add rebalance timeline.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Scuttlebutt Notes Section -->
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center p-3">
                                        <h5 class="mb-0 text-white"><i class="bx bx-note me-2"></i>Scuttlebutt Notes</h5>
                                        <button type="button" class="btn btn-light btn-sm" id="addScuttlebuttBtn">
                                            <i class="bx bx-plus me-1"></i> Add Note
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion" id="scuttlebuttAccordion">
                                            <?php if (!empty($scuttlebuttNotes)): ?>
                                                <?php foreach ($scuttlebuttNotes as $index => $note): ?>
                                                <div class="accordion-item scuttlebutt-item mb-3">
                                                    <h2 class="accordion-header" id="scuttlebuttHeading<?= $index ?>">
                                                        <div class="d-flex align-items-center">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scuttlebuttCollapse<?= $index ?>" aria-expanded="false" aria-controls="scuttlebuttCollapse<?= $index ?>">
                                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                                    <span><i class="bx bx-note me-2"></i> <?= $note['fld_title'] ?></span>
                                                                    <span class="badge bg-success me-2">Note</span>
                                                                </div>
                                                            </button>
                                                            <div class="dropdown ms-2">
                                                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item edit-scuttlebutt" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                                    <li><a class="dropdown-item remove-scuttlebutt" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </h2>
                                                    <div id="scuttlebuttCollapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="scuttlebuttHeading<?= $index ?>">
                                                        <div class="accordion-body">
                                                            <input type="hidden" name="scuttlebutt[id][]" value="<?= $note['id'] ?>">
                                                            
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Title</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="bx bx-heading"></i></span>
                                                                        <input type="text" class="form-control" name="scuttlebutt[title][]" value="<?= $note['fld_title'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label class="form-label small text-muted">Date</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                                                        <input type="date" class="form-control" name="scuttlebutt[date][]" value="<?= $note['fld_date'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-12">
                                                                    <label class="form-label small text-muted">Description</label>
                                                                    <textarea class="form-control scuttlebutt-editor" name="scuttlebutt[description][]" rows="5"><?= $note['fld_description'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="text-center py-5">
                                                    <i class="bx bx-note fs-1 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No scuttlebutt notes added yet</h5>
                                                    <p class="text-muted">Click "Add Note" to add scuttlebutt notes.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Updates Tab -->
                            <div class="tab-pane fade" id="updates" role="tabpanel" aria-labelledby="updates-tab">
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Quarterly Model Portfolio Updates</h5>
                                        <button type="button" class="btn btn-primary btn-sm" id="addQuarterlyBtn">
                                            <i class="bx bx-plus me-1"></i> Add Update
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Video URL</th>
                                                        <th>Description</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="quarterlyTableBody">
                                                    <?php foreach ($quarterlyUpdates as $update): ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="quarterly_updates[title][]" value="<?= $update['fld_title'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="quarterly_updates[video_url][]" value="<?= $update['fld_video_url'] ?>">
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" name="quarterly_updates[description][]"><?= $update['fld_description'] ?></textarea>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm remove-quarterly">
                                                                <i class="bx bx-trash"></i> Remove
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php if (empty($quarterlyUpdates)): ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            <p class="mb-0">No updates added yet. Click "Add Update" to add quarterly updates.</p>
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Management Interviews</h5>
                                        <button type="button" class="btn btn-primary btn-sm" id="addInterviewBtn">
                                            <i class="bx bx-plus me-1"></i> Add Interview
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Video URL</th>
                                                        <th>Description</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="interviewTableBody">
                                                    <?php foreach ($managementInterviews as $interview): ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="interviews[title][]" value="<?= $interview['fld_title'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="interviews[video_url][]" value="<?= $interview['fld_video_url'] ?>">
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" name="interviews[description][]"><?= $interview['fld_description'] ?></textarea>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm remove-interview">
                                                                <i class="bx bx-trash"></i> Remove
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php if (empty($managementInterviews)): ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            <p class="mb-0">No interviews added yet. Click "Add Interview" to add management interviews.</p>
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.classic-tabs {
    border-bottom: 2px solid #dee2e6;
}

.classic-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #495057;
    font-weight: 500;
    padding: 0.75rem 1rem;
    margin-right: 1rem;
}

.classic-tabs .nav-link:hover {
    border-color: #e9ecef;
    color: #0d6efd;
}

.classic-tabs .nav-link.active {
    border-color: #0d6efd;
    color: #0d6efd;
    background-color: transparent;
}

.card-header.bg-light {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6;
}

.table-light th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.feature-item, .stock-item, .update-item, .distribution-item, .rebalance-item {
    transition: all 0.3s ease;
}

.feature-item:hover, .stock-item:hover, .update-item:hover, .distribution-item:hover, .rebalance-item:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.app-image-preview img {
    max-height: 120px;
    object-fit: contain;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

loadEditor('#fld_description', 300);
loadEditor('#fld_description_paid', 200);

// Use document ready to ensure jQuery is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if jQuery is loaded
    if (typeof jQuery == 'undefined') {
        console.log("jQuery is not loaded");
        return;
    }
    
    // jQuery code here
    jQuery(function($) {
        // Add more features
        let featureCount = <?= count($features) ?>;
        $('#addFeatureBtn').click(function() {
            const featureHtml = `
                <div class="feature-item card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Feature Title</label>
                                <input type="hidden" name="feature_ids[]" value="">
                                <input type="text" class="form-control" name="feature_titles[]" required>
                            </div>
                            <div class="col-md-7 mb-3">
                                <label class="form-label">Feature Description</label>
                                <textarea class="form-control feature-description" name="feature_descriptions[]" rows="5"></textarea>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="feature_images_${featureCount}" accept="image/*">
                                <button type="button" class="btn btn-danger btn-sm mt-1 remove-feature w-100">
                                    <i class="bx bx-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#featuresContainer').append(featureHtml);

            loadEditor('.feature-description', 200);

            featureCount++;
        });
        
        // Remove feature
        $(document).on('click', '.remove-feature', function() {
            $(this).closest('.feature-item').fadeOut(300, function() {
                $(this).remove();
            });
        });
        
        // Add distribution
        $('#addDistributionBtn').click(function() {
            // Remove the empty row if exists
            if ($('#distributionTableBody tr td[colspan]').length > 0) {
                $('#distributionTableBody').empty();
            }
            
            const distributionHtml = `
                <tr class="distribution-item">
                    <td>
                        <input type="text" class="form-control" name="distribution[category][]" placeholder="Category" required>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="distribution[percentage][]" placeholder="Percentage" step="0.01" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-distribution">
                            <i class="bx bx-trash"></i> Remove
                        </button>
                    </td>
                </tr>
            `;
            $('#distributionTableBody').append(distributionHtml);
        });
        
        // Remove distribution
        $(document).on('click', '.remove-distribution', function() {
            $(this).closest('tr').fadeOut(300, function() {
                $(this).remove();
                
                // Show empty message if no distributions left
                if ($('#distributionTableBody tr').length === 0) {
                    $('#distributionTableBody').html(`
                        <tr>
                            <td colspan="3" class="text-center">
                                <p class="mb-0">No distribution added yet. Click "Add Distribution" to add portfolio distribution.</p>
                            </td>
                        </tr>
                    `);
                }
            });
        });
        
        // Add quarterly update
        $('#addQuarterlyBtn').click(function() {
            // Remove the empty row if exists
            if ($('#quarterlyTableBody tr td[colspan]').length > 0) {
                $('#quarterlyTableBody').empty();
            }
            
            const updateHtml = `
                <tr class="update-item">
                    <td>
                        <input type="text" class="form-control" name="quarterly_updates[title][]" placeholder="Title" required>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="quarterly_updates[video_url][]" placeholder="Video URL">
                    </td>
                    <td>
                        <textarea class="form-control" name="quarterly_updates[description][]" placeholder="Description"></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-quarterly">
                            <i class="bx bx-trash"></i> Remove
                        </button>
                    </td>
                </tr>
            `;
            $('#quarterlyTableBody').append(updateHtml);
        });
        
        // Remove quarterly update
        $(document).on('click', '.remove-quarterly', function() {
            $(this).closest('tr').fadeOut(300, function() {
                $(this).remove();
                
                // Show empty message if no updates left
                if ($('#quarterlyTableBody tr').length === 0) {
                    $('#quarterlyTableBody').html(`
                        <tr>
                            <td colspan="4" class="text-center">
                                <p class="mb-0">No updates added yet. Click "Add Update" to add quarterly updates.</p>
                            </td>
                        </tr>
                    `);
                }
            });
        });
        
        // Add interview
        $('#addInterviewBtn').click(function() {
            // Remove the empty row if exists
            if ($('#interviewTableBody tr td[colspan]').length > 0) {
                $('#interviewTableBody').empty();
            }
            
            const interviewHtml = `
                <tr class="update-item">
                    <td>
                        <input type="text" class="form-control" name="interviews[title][]" placeholder="Title" required>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="interviews[video_url][]" placeholder="Video URL">
                    </td>
                    <td>
                        <textarea class="form-control" name="interviews[description][]" placeholder="Description"></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-interview">
                            <i class="bx bx-trash"></i> Remove
                        </button>
                    </td>
                </tr>
            `;
            $('#interviewTableBody').append(interviewHtml);
        });
        
        // Remove interview
        $(document).on('click', '.remove-interview', function() {
            $(this).closest('tr').fadeOut(300, function() {
                $(this).remove();
                
                // Show empty message if no interviews left
                if ($('#interviewTableBody tr').length === 0) {
                    $('#interviewTableBody').html(`
                        <tr>
                            <td colspan="4" class="text-center">
                                <p class="mb-0">No interviews added yet. Click "Add Interview" to add management interviews.</p>
                            </td>
                        </tr>
                    `);
                }
            });
        });
        
        // Add stock
        $('#addStockBtn').click(function() {
            // Remove the empty state if exists
            if ($('#stocksAccordion').find('.text-center').length > 0) {
                $('#stocksAccordion').empty();
            }
            
            const stockIndex = $('.stock-item').length;
            const stockHtml = `
                <div class="accordion-item stock-item mb-3">
                    <h2 class="accordion-header" id="heading${stockIndex}">
                        <div class="d-flex align-items-center">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${stockIndex}" aria-expanded="false" aria-controls="collapse${stockIndex}">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span><i class="bx bx-buildings me-2"></i> New Stock</span>
                                    <span class="badge bg-primary">New</span>
                                </div>
                            </button>
                            <div class="dropdown ms-2">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit-stock" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item remove-stock" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </h2>
                    <div id="collapse${stockIndex}" class="accordion-collapse collapse" aria-labelledby="heading${stockIndex}">
                        <div class="accordion-body">
                            <input type="hidden" name="stocks[id][]" value="">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Stock Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                        <input type="text" class="form-control" name="stocks[name][]" placeholder="Enter stock name" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Date of Recommendation</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" class="form-control" name="stocks[date][]" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Price (₹)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="stocks[price][]" step="0.01" placeholder="Price" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">CMP (₹)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="stocks[cmp][]" step="0.01" placeholder="CMP">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Returns (%)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="stocks[returns][]" step="0.01" placeholder="Returns">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Allocation (%)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="stocks[allocation][]" step="0.01" placeholder="Allocation" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Action</label>
                                    <select class="form-select" name="stocks[action][]" required>
                                        <option value="">Select</option>
                                        <option value="Buy">Buy</option>
                                        <option value="Sell">Sell</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Sector</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-category"></i></span>
                                        <input type="text" class="form-control" name="stocks[sector][]" placeholder="Sector" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Rating</label>
                                    <select class="form-select" name="stocks[rating][]" required>
                                        <option value="">Rating</option>
                                        <option value="1">1 Star</option>
                                        <option value="2">2 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="5">5 Stars</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Report</label>
                                    <input type="file" class="form-control form-control-sm" name="stocks_report[]" accept=".pdf,.doc,.docx">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#stocksAccordion').append(stockHtml);
            
            // Add animation
            $('.stock-item:last').hide().fadeIn(300);
        });

        // Remove stock
        $(document).on('click', '.remove-stock', function(e) {
            e.preventDefault();
            const stockItem = $(this).closest('.stock-item');
            
            if (confirm('Are you sure you want to remove this stock?')) {
                stockItem.fadeOut(300, function() {
                    $(this).remove();
                    
                    // Show empty state if no stocks left
                    if ($('#stocksAccordion .stock-item').length === 0) {
                        $('#stocksAccordion').html(`
                            <div class="text-center py-5">
                                <i class="bx bx-line-chart fs-1 text-muted"></i>
                                <h5 class="mt-3 text-muted">No stocks added yet</h5>
                                <p class="text-muted">Click "Add New Stock" to add stocks to the portfolio.</p>
                            </div>
                        `);
                    }
                });
            }
        });

        // Add stock update
        $('#addStockUpdateBtn').click(function() {
            
            // Get current stocks for the dropdown
            let stockOptions = '';
            $('.stock-item').each(function() {
                const stockName = $(this).find('input[name="stocks[name][]"]').val();
                const stockId = $(this).find('input[name="stocks[id][]"]').val();
                if (stockName) {
                    stockOptions += `<option value="${stockId}">${stockName}</option>`;
                }
            });
            
            // If no stocks exist, add a message
            if (stockOptions === '') {
                stockOptions = '<option value="">No stocks available</option>';
            }
            
            const updateIndex = $('.update-item').length;
            const updateHtml = `
                <div class="accordion-item update-item mb-3">
                    <h2 class="accordion-header" id="updateHeading${updateIndex}">
                        <div class="d-flex align-items-center">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#updateCollapse${updateIndex}" aria-expanded="false" aria-controls="updateCollapse${updateIndex}">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span><i class="bx bx-refresh me-2"></i> New Update</span>
                                    <span class="badge bg-info">Update</span>
                                </div>
                            </button>
                            <div class="dropdown ms-2">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit-update" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item remove-update" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </h2>
                    <div id="updateCollapse${updateIndex}" class="accordion-collapse collapse" aria-labelledby="updateHeading${updateIndex}">
                        <div class="accordion-body">
                            <input type="hidden" name="stock_updates[id][]" value="">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Stock</label>
                                    <select class="form-select" name="stock_updates[stock][]" required>
                                        <option value="">Select Stock</option>
                                        ${stockOptions}
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Update Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" class="form-control" name="stock_updates[date][]" required>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label small text-muted">Update Description</label>
                                    <textarea class="form-control stock-update-editor" name="stock_updates[description][]" rows="5" placeholder="Enter update description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#stockUpdatesAccordion').append(updateHtml);
            
            // Add animation
            $('.update-item:last').hide().fadeIn(300);
            
            loadEditor('.stock-update-editor');            
        });

        // Remove stock update
        $(document).on('click', '.remove-update', function(e) {
            e.preventDefault();
            const updateItem = $(this).closest('.update-item');
            
            if (confirm('Are you sure you want to remove this update?')) {
                updateItem.fadeOut(300, function() {
                    $(this).remove();
                    
                    // Show empty state if no updates left
                    if ($('#stockUpdatesAccordion .update-item').length === 0) {
                        $('#stockUpdatesAccordion').html(`
                            <div class="text-center py-5">
                                <i class="bx bx-refresh fs-1 text-muted"></i>
                                <h5 class="mt-3 text-muted">No updates added yet</h5>
                                <p class="text-muted">Click "Add New Update" to add stock updates.</p>
                            </div>
                        `);
                    }
                });
            }
        });

        loadEditor('.stock-update-editor');
        loadEditor('.feature-description', 200);

        // Add rebalance
        $('#addRebalanceBtn').click(function() {
            
            const rebalanceIndex = $('.rebalance-item').length;
            const rebalanceHtml = `
                <div class="accordion-item rebalance-item mb-3">
                    <h2 class="accordion-header" id="rebalanceHeading${rebalanceIndex}">
                        <div class="d-flex align-items-center">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rebalanceCollapse${rebalanceIndex}" aria-expanded="false" aria-controls="rebalanceCollapse${rebalanceIndex}">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span><i class="bx bx-timeline me-2"></i> New Rebalance</span>
                                    <span class="badge bg-warning me-2">Rebalance</span>
                                </div>
                            </button>
                            <div class="dropdown ms-2">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit-rebalance" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item remove-rebalance" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </h2>
                    <div id="rebalanceCollapse${rebalanceIndex}" class="accordion-collapse collapse" aria-labelledby="rebalanceHeading${rebalanceIndex}">
                        <div class="accordion-body">
                            <input type="hidden" name="rebalance[id][]" value="">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" class="form-control" name="rebalance[date][]" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Constituents Change</label>
                                    <div class="d-flex gap-2">
                                        <div class="input-group">
                                            <span class="input-group-text text-success">+</span>
                                            <input type="number" class="form-control"
                                                name="rebalance[constituents_plus][]"
                                                placeholder="Ex. +1"
                                                min="0">
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-text text-danger">−</span>
                                            <input type="number" class="form-control"
                                                name="rebalance[constituents_minus][]"
                                                placeholder="Ex. -1"
                                                min="0">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Factsheet</label>
                                    <input type="file" class="form-control form-control-sm" name="rebalance_factsheet[]" accept=".pdf,.doc,.docx">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Description</label>
                                    <textarea class="form-control rebalance-editor" name="rebalance[description][]" rows="5" placeholder="Enter description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#rebalanceAccordion').append(rebalanceHtml);
            
            // Add animation
            $('.rebalance-item:last').hide().fadeIn(300);
            
            loadEditor('.rebalance-editor', 200);            
        });

        // Remove rebalance
        $(document).on('click', '.remove-rebalance', function(e) {
            e.preventDefault();
            const rebalanceItem = $(this).closest('.accordion-item');
            
            if (confirm('Are you sure you want to remove this rebalance?')) {
                rebalanceItem.fadeOut(300, function() {
                    $(this).remove();
                    
                    // Show empty state if no rebalances left
                    if ($('#rebalanceAccordion .accordion-item').length === 0) {
                        $('#rebalanceAccordion').html(`
                            <div class="text-center py-5">
                                <i class="bx bx-timeline fs-1 text-muted"></i>
                                <h5 class="mt-3 text-muted">No rebalance added yet</h5>
                                <p class="text-muted">Click "Add Rebalance" to add rebalance timeline.</p>
                            </div>
                        `);
                    }
                });
            }
        });

        loadEditor('.rebalance-editor', 200);
        
        // Add scuttlebutt note
        $('#addScuttlebuttBtn').click(function() {
            
            const scuttlebuttIndex = $('.scuttlebutt-item').length;
            const scuttlebuttHtml = `
                <div class="accordion-item scuttlebutt-item mb-3">
                    <h2 class="accordion-header" id="scuttlebuttHeading${scuttlebuttIndex}">
                        <div class="d-flex align-items-center">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scuttlebuttCollapse${scuttlebuttIndex}" aria-expanded="false" aria-controls="scuttlebuttCollapse${scuttlebuttIndex}">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span><i class="bx bx-note me-2"></i> New Note</span>
                                    <span class="badge bg-success me-2">Note</span>
                                </div>
                            </button>
                            <div class="dropdown ms-2">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit-scuttlebutt" href="#"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item remove-scuttlebutt" href="#"><i class="bx bx-trash me-2"></i>Remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </h2>
                    <div id="scuttlebuttCollapse${scuttlebuttIndex}" class="accordion-collapse collapse" aria-labelledby="scuttlebuttHeading${scuttlebuttIndex}">
                        <div class="accordion-body">
                            <input type="hidden" name="scuttlebutt[id][]" value="">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Title</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-heading"></i></span>
                                        <input type="text" class="form-control" name="scuttlebutt[title][]" placeholder="Enter title" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" class="form-control" name="scuttlebutt[date][]" required>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label small text-muted">Description</label>
                                    <textarea class="form-control scuttlebutt-editor" name="scuttlebutt[description][]" rows="5" placeholder="Enter description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#scuttlebuttAccordion').append(scuttlebuttHtml);
            
            // Add animation
            $('.scuttlebutt-item:last').hide().fadeIn(300);
            
            loadEditor('.scuttlebutt-editor');
        });

        // Remove scuttlebutt note
        $(document).on('click', '.remove-scuttlebutt', function(e) {
            e.preventDefault();
            const scuttlebuttItem = $(this).closest('.accordion-item');
            
            if (confirm('Are you sure you want to remove this scuttlebutt note?')) {
                scuttlebuttItem.fadeOut(300, function() {
                    $(this).remove();
                    
                    // Show empty state if no notes left
                    if ($('#scuttlebuttAccordion .accordion-item').length === 0) {
                        $('#scuttlebuttAccordion').html(`
                            <div class="text-center py-5">
                                <i class="bx bx-note fs-1 text-muted"></i>
                                <h5 class="mt-3 text-muted">No scuttlebutt notes added yet</h5>
                                <p class="text-muted">Click "Add Note" to add scuttlebutt notes.</p>
                            </div>
                        `);
                    }
                });
            }
        });

        loadEditor('.scuttlebutt-editor');

        // Form validation
        $('#productForm').on('submit', function(e) {
            // Validate portfolio distribution percentages
            let totalPercentage = 0;
            $('input[name="distribution[percentage][]"]').each(function() {
                if ($(this).val()) {
                    totalPercentage += parseFloat($(this).val());
                }
            });
            
            if (totalPercentage !== 100 && totalPercentage > 0) {
                e.preventDefault();
                alert('Total portfolio distribution must equal 100%. Current total: ' + totalPercentage + '%');
            }
        });

    });
});
</script>
<style>
/* Card-based layout styles */
.stock-card, .update-card {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
    overflow: hidden;
}

.stock-card:hover, .update-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.stock-card .card-header, .update-card .card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    background-color: #f8f9fa;
}

.form-label.small {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
}

.input-group .form-control:focus {
    border-color: #ced4da;
    box-shadow: none;
}

.input-group .form-control:focus + .input-group-text {
    border-color: #ced4da;
}

.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: none;
    border-radius: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item i {
    font-size: 1rem;
}

/* Animation for adding cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stock-item, .update-item {
    animation: fadeInUp 0.5s ease;
}

.tox .tox-toolbar__primary {
    background-color: #f8f9fa !important;
    border-radius: 0.375rem 0.375rem 0 0 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stock-card, .update-card {
        margin-bottom: 1rem;
    }
    
    .card-header h6 {
        font-size: 0.9rem;
    }
}
</style>
<?= $this->endSection() ?>