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
          
          <form action="<?= base_url('admin/users/store') ?>" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile" value="<?= old('mobile') ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
              </div>
            </div>
            
            <div class="form-group mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" id="address" name="address" rows="3"><?= old('address') ?></textarea>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="1" <?= old('status') == '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= old('status') == '0' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                  <select class="form-select" id="role" name="role" required>
                    <option value="user" selected>User</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('admin/users') ?>" class="btn btn-label-secondary me-2">Cancel</a>
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