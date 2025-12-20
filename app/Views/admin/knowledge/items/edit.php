<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Knowledge Item</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/knowledge-centre/update-item/' . $item['id']) ?>" method="post">
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Category <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" name="fld_category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $item['fld_category_id'] == $category['id'] ? 'selected' : '' ?>>
                                        <?= $category['fld_title'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($validation->getError('fld_category_id')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_category_id') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Title <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fld_title" value="<?= $item['fld_title'] ?>" required>
                                <?php if ($validation->getError('fld_title')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_title') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Video URL <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fld_video_url" value="<?= $item['fld_video_url'] ?>" required>
                                <?php if ($validation->getError('fld_video_url')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_video_url') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Duration</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fld_duration" value="<?= $item['fld_duration'] ?>" placeholder="e.g., 10:30">
                                <?php if ($validation->getError('fld_duration')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_duration') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Description <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="fld_description" rows="4" required><?= $item['fld_description'] ?></textarea>
                                <?php if ($validation->getError('fld_description')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_description') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Posted At <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="fld_posted_at" value="<?= $item['fld_posted_at'] ?>" required>
                                <?php if ($validation->getError('fld_posted_at')): ?>
                                    <div class="text-danger"><?= $validation->getError('fld_posted_at') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="fld_status" id="fld_status" <?= $item['fld_status'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="fld_status">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="<?= base_url('admin/knowledge-centre/items') ?>" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Item</button>
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