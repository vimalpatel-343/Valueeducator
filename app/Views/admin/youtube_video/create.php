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
          
          <form action="<?= base_url('admin/youtube-videos/store') ?>" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="video_id" class="form-label">YouTube Video ID <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="video_id" name="video_id" value="<?= old('video_id') ?>" required>
                  <small class="text-muted">The 11-character ID from the YouTube URL (e.g., dQw4w9WgXcQ)</small>
                </div>
              </div>
            </div>
            
            <div class="form-group mb-3">
              <label class="form-label">Assign to <span class="text-danger">*</span></label>
              <div class="border rounded p-3">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="general" id="general_video" name="assignments[]" checked>
                  <label class="form-check-label" for="general_video">
                    General (Show on Home Page)
                  </label>
                </div>
                
                <?php if (!empty($products)): ?>
                  <?php foreach ($products as $product): ?>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="<?= $product['id'] ?>" id="product_<?= $product['id'] ?>" name="assignments[]">
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
                <option value="1" <?= old('status') == '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= old('status') == '0' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
            
            <div class="alert alert-info">
              <i class="bx bx-info-circle me-1"></i> Video details (title, description, views, posted date) will be automatically fetched from YouTube API.
            </div>
            
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('admin/youtube-videos') ?>" class="btn btn-label-secondary me-2">Cancel</a>
              <button type="submit" class="btn btn-primary">Save</button>
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