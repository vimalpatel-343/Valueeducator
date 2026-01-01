<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0"><?= $title ?></h5>
        </div>
        <div class="card-body">
          <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                  <li><?= $error ?></li>
                <?php endforeach; ?>
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
          <form action="<?= base_url('admin/youtube-videos/update/' . $video['id']) ?>" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="video_id" class="form-label">YouTube Video ID <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="video_id" name="video_id" value="<?= old('video_id', $video['fld_video_id']) ?>" readonly>
                  <small class="text-muted">Video ID cannot be changed</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="total_views" class="form-label">Total Views</label>
                  <input type="number" class="form-control" id="total_views" name="total_views" value="<?= old('total_views', $video['fld_total_views']) ?>">
                </div>
              </div>
            </div>
            
            <div class="form-group mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $video['fld_title']) ?>">
            </div>
            
            <div class="form-group mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $video['fld_description']) ?></textarea>
            </div>
            
            <div class="form-group mb-3">
              <label for="posted_at" class="form-label">Posted Date</label>
              <input type="datetime-local" class="form-control" id="posted_at" name="posted_at" value="<?= old('posted_at', date('Y-m-d\TH:i', strtotime($video['fld_posted_at']))) ?>">
            </div>
            
            <div class="form-group mb-3">
              <label class="form-label">Assign to <span class="text-danger">*</span></label>
              <div class="border rounded p-3">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="general" id="general_video" name="assignments[]" <?= $video['is_general'] ? 'checked' : '' ?>>
                  <label class="form-check-label" for="general_video">
                    General (Show on Home Page)
                  </label>
                </div>
                
                <?php if (!empty($products)): ?>
                  <?php foreach ($products as $product): ?>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="<?= $product['id'] ?>" id="product_<?= $product['id'] ?>" name="assignments[]" <?= isset($video['products']) && in_array($product['id'], $video['products']) ? 'checked' : '' ?>>
                      <label class="form-check-label" for="product_<?= $product['id'] ?>">
                        <?= $product['fld_title'] ?>
                      </label>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <small class="text-muted">You can select General and/or any combination of products</small>
            </div>
            
            <div class="form-group mb-3">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select" id="status" name="status" required>
                <option value="1" <?= old('status', $video['fld_status']) == '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= old('status', $video['fld_status']) == '0' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
            
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('admin/youtube-videos') ?>" class="btn btn-label-secondary me-2">Cancel</a>
              <button type="submit" class="btn btn-primary">Update</button>
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
// No additional script needed for this approach
</script>
<?= $this->endSection() ?>