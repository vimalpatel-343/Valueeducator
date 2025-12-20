<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><?= $title ?></h5>
            <a href="<?= base_url('admin/admin-users/create') ?>" class="btn btn-primary">
              <i class="bx bx-plus me-1"></i> Add New Admin User
            </a>
          </div>
        </div>
        <div class="card-body">
          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <?= session()->getFlashdata('success') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <?= session()->getFlashdata('error') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Last Login</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($adminUsers)): ?>
                  <?php foreach ($adminUsers as $adminUser): ?>
                    <tr>
                      <td><?= $adminUser['id'] ?></td>
                      <td><?= $adminUser['fld_full_name'] ?></td>
                      <td><?= $adminUser['fld_email'] ?></td>
                      <td>
                        <span class="badge bg-label-<?= $adminUser['fld_role'] === 'superadmin' ? 'danger' : 'warning' ?>">
                          <?= ucfirst($adminUser['fld_role']) ?>
                        </span>
                      </td>
                      <td>
                        <?php if ($adminUser['fld_status'] == 1): ?>
                          <span class="badge bg-label-success">Active</span>
                        <?php else: ?>
                          <span class="badge bg-label-danger">Inactive</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($adminUser['fld_last_login']): ?>
                          <?= date('M d, Y H:i', strtotime($adminUser['fld_last_login'])) ?>
                        <?php else: ?>
                          <span class="text-muted">Never</span>
                        <?php endif; ?>
                      </td>
                      <td><?= date('M d, Y', strtotime($adminUser['fld_created_at'])) ?></td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url('admin/admin-users/edit/' . $adminUser['id']) ?>">
                              <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <?php if ($adminUser['fld_role'] !== 'superadmin'): ?>
                              <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDelete(<?= $adminUser['id'] ?>)">
                                <i class="bx bx-trash me-1"></i> Delete
                              </a>
                            <?php endif; ?>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center">No admin users found</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this admin user?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" method="POST" action="">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function confirmDelete(id) {
    document.getElementById('deleteForm').action = '<?= base_url('admin/admin-users/delete/') ?>' + id;
    $('#deleteModal').modal('show');
  }
</script>
<?= $this->endSection() ?>