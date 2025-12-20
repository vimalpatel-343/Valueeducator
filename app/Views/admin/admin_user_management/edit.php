<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><?= $title ?></h5>
            <a href="<?= base_url('admin/admin-users') ?>" class="btn btn-secondary">
              <i class="bx bx-arrow-back me-1"></i> Back to Admin Users
            </a>
          </div>
        </div>
        <div class="card-body">
          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <?= session()->getFlashdata('error') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
          <form method="POST" action="<?= base_url('admin/admin-users/update/' . $adminUser['id']) ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name', $adminUser['fld_full_name']) ?>" required>
                  <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                    <div class="invalid-feedback d-block">
                      <?= $validation->getError('full_name') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $adminUser['fld_email']) ?>" required>
                  <?php if (isset($validation) && $validation->hasError('email')): ?>
                    <div class="invalid-feedback d-block">
                      <?= $validation->getError('email') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                  <input type="password" class="form-control" id="password" name="password">
                  <?php if (isset($validation) && $validation->hasError('password')): ?>
                    <div class="invalid-feedback d-block">
                      <?= $validation->getError('password') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="confirm_password" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                  <select class="form-select" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin" <?= old('role', $adminUser['fld_role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="superadmin" <?= old('role', $adminUser['fld_role']) == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                  </select>
                  <?php if (isset($validation) && $validation->hasError('role')): ?>
                    <div class="invalid-feedback d-block">
                      <?= $validation->getError('role') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="1" <?= old('status', $adminUser['fld_status']) == '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= old('status', $adminUser['fld_status']) == '0' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                  <?php if (isset($validation) && $validation->hasError('status')): ?>
                    <div class="invalid-feedback d-block">
                      <?= $validation->getError('status') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Created Date</label>
                  <input type="text" class="form-control" value="<?= date('M d, Y H:i', strtotime($adminUser['fld_created_at'])) ?>" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Last Login</label>
                  <input type="text" class="form-control" value="<?= $adminUser['fld_last_login'] ? date('M d, Y H:i', strtotime($adminUser['fld_last_login'])) : 'Never' ?>" readonly>
                </div>
              </div>
            </div>
            
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('admin/admin-users') ?>" class="btn btn-secondary me-2">Cancel</a>
              <button type="submit" class="btn btn-primary">Update Admin User</button>
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
  // Password confirmation validation
  document.querySelector('form').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    
    if (password && password !== confirmPassword) {
      e.preventDefault();
      alert('Password and confirm password do not match');
    }
  });
</script>
<?= $this->endSection() ?>