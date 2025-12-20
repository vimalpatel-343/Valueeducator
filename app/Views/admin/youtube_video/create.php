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
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="product_id" class="form-label">Product</label>
                  <select class="form-select" id="product_id" name="product_id">
                    <option value="">General Video</option>
                    <?php if (!empty($products)): ?>
                      <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id'] ?>" <?= old('product_id') == $product['id'] ? 'selected' : '' ?>>
                          <?= $product['fld_title'] ?>
                        </option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                </div>
              </div>
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
  // Add any JavaScript needed for this page
</script>
<?= $this->endSection() ?>