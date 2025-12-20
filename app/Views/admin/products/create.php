<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Create Product</h4>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data" id="productForm">
                        <!-- Basic Details -->
                        <div class="mb-4">
                            <h5 class="card-title">Basic Details</h5>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Product Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fld_title" value="<?= old('fld_title') ?>" required>
                                    <?php if ($validation->getError('fld_title')): ?>
                                        <div class="text-danger"><?= $validation->getError('fld_title') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="fld_description" rows="3" required><?= old('fld_description') ?></textarea>
                                    <?php if ($validation->getError('fld_description')): ?>
                                        <div class="text-danger"><?= $validation->getError('fld_description') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Video URL</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fld_video_url" value="<?= old('fld_video_url') ?>">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Research Framework</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="fld_research_framework" rows="2"><?= old('fld_research_framework') ?></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Market Cap Focus</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fld_market_cap_focus" value="<?= old('fld_market_cap_focus') ?>" required>
                                    <?php if ($validation->getError('fld_market_cap_focus')): ?>
                                        <div class="text-danger"><?= $validation->getError('fld_market_cap_focus') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">No. of Ideas/Year</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fld_no_of_ideas" value="<?= old('fld_no_of_ideas') ?>" required>
                                    <?php if ($validation->getError('fld_no_of_ideas')): ?>
                                        <div class="text-danger"><?= $validation->getError('fld_no_of_ideas') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Holding Period</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fld_holding_period" value="<?= old('fld_holding_period') ?>" required>
                                    <?php if ($validation->getError('fld_holding_period')): ?>
                                        <div class="text-danger"><?= $validation->getError('fld_holding_period') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Pricing (₹)</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="fld_pricing" value="<?= old('fld_pricing') ?>" step="0.01" required>
                                    <?php if ($validation->getError('fld_pricing')): ?>
                                        <div class="text-danger"><?= $validation->getError('fld_pricing') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="fld_status" id="fld_status" checked>
                                        <label class="form-check-label" for="fld_status">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Features -->
                        <div class="mb-4">
                            <h5 class="card-title">Product Features</h5>
                            <div id="featuresContainer">
                                <div class="feature-item mb-3">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="feature_titles[]" placeholder="Feature Title">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="feature_descriptions[]" placeholder="Feature Description">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="file" class="form-control" name="feature_images_0" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addFeatureBtn">
                                <i class="bx bx-plus"></i> Add Feature
                            </button>
                        </div>
                        
                        <!-- App Images -->
                        <div class="mb-4">
                            <h5 class="card-title">App Images (Max 5)</h5>
                            <div class="row">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="app-image-preview mb-2">
                                                <img src="<?= base_url('assets/img/no-image.png') ?>" class="img-fluid" alt="App Image">
                                            </div>
                                            <input type="file" class="form-control" name="app_images[]" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary me-2">Save Product</button>
                                <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
 $(document).ready(function() {
    // Add more features
    let featureCount = 1;
    $('#addFeatureBtn').click(function() {
        const featureHtml = `
            <div class="feature-item mb-3">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="feature_titles[]" placeholder="Feature Title">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="feature_descriptions[]" placeholder="Feature Description">
                    </div>
                    <div class="col-md-2">
                        <input type="file" class="form-control" name="feature_images_${featureCount}" accept="image/*">
                        <button type="button" class="btn btn-danger btn-sm mt-1 remove-feature"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
        $('#featuresContainer').append(featureHtml);
        featureCount++;
    });
    
    // Remove feature
    $(document).on('click', '.remove-feature', function() {
        $(this).closest('.feature-item').remove();
    });
    
    // Preview app images
    $('input[name="app_images[]"]').change(function() {
        const reader = new FileReader();
        reader.onload = function(e) {
            $(this).siblings('.app-image-preview').find('img').attr('src', e.target.result);
        }.bind(this);
        reader.readAsDataURL(this.files[0]);
    });
});
</script>
<?= $this->endSection() ?>