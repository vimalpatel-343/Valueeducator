<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Knowledge Centre / Sectors /</span> Create Sector</h4>
    
    <!-- Alerts -->
    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php foreach (session('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Create Sector Form -->
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Sector Information</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/knowledge-centre/store-sector') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Sector Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="used_for" class="form-label">Used For</label>
                            <select class="form-select" id="used_for" name="used_for" required>
                                <option value="1" <?= old('used_for') == '1' ? 'selected' : '' ?>>Knowledge Sector</option>
                                <option value="2" <?= old('used_for') == '2' ? 'selected' : '' ?>>Report</option>
                                <option value="3" <?= old('used_for') == '3' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Upload sector image (JPG, PNG, GIF)</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                            <div class="form-text">Upload sector icon (JPG, PNG, GIF)</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', 0) ?>" required>
                            <div class="form-text">Lower numbers appear first</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" <?= old('active') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Save Sector</button>
                        <a href="<?= base_url('admin/knowledge-centre/sectors') ?>" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>