<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Substack Update</h5>
                </div>
                <div class="card-body">
                    <!-- Alerts -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Form -->
                    <form action="<?= base_url('admin/substack-updates/update/' . $update['id']) ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fld_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="fld_title" name="fld_title" value="<?= old('fld_title', $update['fld_title']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fld_product_ids" class="form-label">Products</label>
                                <select class="form-select" id="fld_product_ids" name="fld_product_ids[]" multiple required>
                                    <?php 
                                    // Convert comma-separated IDs to array for selected options
                                    $selectedProducts = !empty($update['fld_product_ids']) ? explode(',', $update['fld_product_ids']) : [];
                                    ?>
                                    <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['id'] ?>" <?= in_array($product['id'], old('fld_product_ids', $selectedProducts)) ? 'selected' : '' ?>><?= $product['fld_title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">Hold Ctrl/Cmd to select multiple products</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fld_description" class="form-label">Description</label>
                            <textarea class="form-control" id="fld_description" name="fld_description" rows="4" required><?= old('fld_description', $update['fld_description']) ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fld_url" class="form-label">URL</label>
                                <input type="url" class="form-control" id="fld_url" name="fld_url" value="<?= old('fld_url', $update['fld_url']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fld_image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="fld_image" name="fld_image" accept="image/*">
                                <?php if (!empty($update['fld_image'])): ?>
                                <div class="mt-2">
                                    <img src="<?= base_url($update['fld_image']) ?>" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="fld_status" name="fld_status" value="1" <?= $update['fld_status'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="fld_status">
                                Active
                            </label>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="<?= base_url('admin/substack-updates') ?>" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>