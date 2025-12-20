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
          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <?= session()->getFlashdata('success') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
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
          
          <form action="<?= base_url('admin/settings/update') ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="site_title" class="form-label">Site Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="site_title" name="site_title" value="<?= old('site_title', $settings['fld_site_title']) ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $settings['fld_email']) ?>" required>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile" value="<?= old('mobile', $settings['fld_mobile']) ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="full_address" class="form-label">Full Address</label>
                  <textarea class="form-control" id="full_address" name="full_address" rows="2"><?= old('full_address', $settings['fld_full_address']) ?></textarea>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="latitude" class="form-label">Latitude</label>
                  <input type="text" class="form-control" id="latitude" name="latitude" value="<?= old('latitude', $settings['fld_latitude']) ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="longitude" class="form-label">Longitude</label>
                  <input type="text" class="form-control" id="longitude" name="longitude" value="<?= old('longitude', $settings['fld_longitude']) ?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="meta_description" class="form-label">Meta Description</label>
                  <textarea class="form-control" id="meta_description" name="meta_description" rows="2"><?= old('meta_description', $settings['fld_meta_description']) ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="meta_keywords" class="form-label">Meta Keywords</label>
                  <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="2"><?= old('meta_keywords', $settings['fld_meta_keywords']) ?></textarea>
                </div>
              </div>
            </div>
            
            <!-- Statistics Fields -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Home Page Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="hidden_gems" class="form-label">Hidden Gems Discovered <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="hidden_gems" name="hidden_gems" value="<?= old('hidden_gems', $settings['fld_hidden_gems'] ?? '50') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="youtube_subscribers" class="form-label">YouTube Subscribers <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="youtube_subscribers" name="youtube_subscribers" value="<?= old('youtube_subscribers', $settings['fld_youtube_subscribers'] ?? '143000') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="investors_empowered" class="form-label">Investors Empowered <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="investors_empowered" name="investors_empowered" value="<?= old('investors_empowered', $settings['fld_investors_empowered'] ?? '2000') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="years_experience" class="form-label">Years of Combined Experience <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="years_experience" name="years_experience" value="<?= old('years_experience', $settings['fld_years_experience'] ?? '60') ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="header_logo" class="form-label">Header Logo</label>
                  <input type="file" class="form-control" id="header_logo" name="header_logo" accept="image/*">
                  <input type="hidden" name="current_header_logo" value="<?= $settings['fld_header_logo'] ?>">
                  <?php if (!empty($settings['fld_header_logo'])): ?>
                    <div class="mt-2">
                      <img src="<?= base_url($settings['fld_header_logo']) ?>" alt="Header Logo" class="rounded" width="100" height="50">
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="footer_logo" class="form-label">Footer Logo</label>
                  <input type="file" class="form-control" id="footer_logo" name="footer_logo" accept="image/*">
                  <input type="hidden" name="current_footer_logo" value="<?= $settings['fld_footer_logo'] ?>">
                  <?php if (!empty($settings['fld_footer_logo'])): ?>
                    <div class="mt-2">
                      <img src="<?= base_url($settings['fld_footer_logo']) ?>" alt="Footer Logo" class="rounded" width="100" height="50">
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            
            <div class="form-group mb-3">
              <label for="ebook" class="form-label">E-Book</label>
              <input type="file" class="form-control" id="ebook" name="ebook" accept=".pdf">
              <input type="hidden" name="current_ebook" value="<?= $settings['fld_ebook'] ?>">
              <?php if (!empty($settings['fld_ebook'])): ?>
                <div class="mt-2">
                  <a href="<?= base_url($settings['fld_ebook']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bx bx-file me-1"></i> View Current E-Book
                  </a>
                </div>
              <?php endif; ?>
            </div>
            
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update Settings</button>
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