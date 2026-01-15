<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Knowledge Centre /</span> Create Report</h4>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= base_url('admin/knowledge-centre/store-report') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="<?= old('company_name') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sector_id" class="form-label">Sector <span class="text-danger">*</span></label>
                                <select class="form-select" id="sector_id" name="sector_id" required>
                                    <option value="">Select Sector</option>
                                    <?php foreach ($sectors as $sector): ?>
                                        <option value="<?= $sector['id'] ?>" <?= old('sector_id') == $sector['id'] ? 'selected' : '' ?>><?= $sector['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="market_cap" class="form-label">Market Cap <span class="text-danger">*</span></label>
                                <select class="form-select" id="market_cap" name="market_cap" required>
                                    <option value="">Select Market Cap</option>
                                    <?php foreach ($marketCaps as $key => $value): ?>
                                        <option value="<?= $key ?>" <?= old('market_cap') == $key ? 'selected' : '' ?>><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', 0) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Allowed formats: JPG, PNG, SVG. Max size: 1MB</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="10" required><?= old('description') ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" <?= old('active', '1') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="recommended" name="recommended" value="1" <?= old('recommended') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="recommended">Recommended</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('admin/knowledge-centre/reports') ?>" class="btn btn-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Back to Reports
                            </a>
                            <button type="submit" class="btn btn-primary">Save Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
 $(document).ready(function() {
    loadEditor('#description');
});
</script>
<?= $this->endSection() ?>