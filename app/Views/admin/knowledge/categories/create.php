<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create Knowledge Category</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/knowledge-centre/store-category') ?>" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Title <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fld_title" value="<?= old('fld_title') ?>" required>
                                <?php if ($validation->getError('fld_title')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_title') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Image <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" name="fld_image" accept="image/*" required>
                                <small class="text-muted">Allowed file types: jpg, jpeg, png. Max size: 1MB</small>
                                <?php if ($validation->getError('fld_image')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_image') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="fld_status" id="fld_status" checked>
                                    <label class="form-check-label" for="fld_status">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="<?= base_url('admin/knowledge-centre/categories') ?>" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>