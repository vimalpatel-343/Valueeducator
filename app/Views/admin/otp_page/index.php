<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">UPI ID</h5>
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
          
          <form action="<?= base_url('admin/upi-id/update') ?>" method="POST">
            <div class="form-group mb-3">
              <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $content ? $content['fld_title'] : 'OTP Page') ?>" required>
            </div>
            
            <div class="form-group mb-3">
              <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
              <textarea class="form-control" id="content" name="content" rows="15"><?= old('content', $content ? $content['fld_content'] : '') ?></textarea>
            </div>
            
            <div class="form-group mb-3">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select" id="status" name="status" required>
                <option value="1" <?= old('status', $content ? $content['fld_status'] : '1') == '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= old('status', $content ? $content['fld_status'] : '1') == '0' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
            
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Update Content</button>
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
  loadEditor('#content');
</script>
<?= $this->endSection() ?>