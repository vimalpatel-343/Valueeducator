<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Knowledge Category</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/knowledge-centre/update-category/' . $category['id']) ?>" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Title <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fld_title" value="<?= $category['fld_title'] ?>" required>
                                <?php if ($validation->getError('fld_title')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_title') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Current Image</label>
                            <div class="col-md-9">
                                <?php if ($category['fld_image']): ?>
                                    <img src="<?= base_url($category['fld_image']) ?>" class="img-thumbnail" style="max-height: 100px;" alt="Category Image">
                                <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">New Image</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" name="fld_image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image. Allowed file types: jpg, jpeg, png. Max size: 1MB</small>
                                <?php if ($validation->getError('fld_image')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_image') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="fld_status" id="fld_status" <?= $category['fld_status'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="fld_status">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="<?= base_url('admin/knowledge-centre/categories') ?>" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Category</button>
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