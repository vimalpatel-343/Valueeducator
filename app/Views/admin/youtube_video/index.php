<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><?= $title ?></h5>
            <a href="<?= base_url('admin/youtube-videos/create') ?>" class="btn btn-primary">
              <i class="bx bx-plus me-1"></i> Add New
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
                  <th>Thumbnail</th>
                  <th>Title</th>
                  <th>Video ID</th>
                  <th>Views</th>
                  <th>Posted Date</th>
                  <th>Product</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($videos)): ?>
                  <?php foreach ($videos as $video): ?>
                    <tr>
                      <td><?= $video['id'] ?></td>
                      <td>
                        <img src="https://img.youtube.com/vi/<?= $video['fld_video_id'] ?>/default.jpg" alt="<?= $video['fld_title'] ?>" class="rounded" width="80" height="60">
                      </td>
                      <td><?= $video['fld_title'] ?></td>
                      <td><?= $video['fld_video_id'] ?></td>
                      <td><?= number_format($video['fld_total_views']) ?></td>
                      <td><?= date('M d, Y', strtotime($video['fld_posted_at'])) ?></td>
                      <td>
                        <?php if (!empty($video['product_title'])): ?>
                          <span class="badge bg-label-primary"><?= $video['product_title'] ?></span>
                        <?php else: ?>
                          <span class="badge bg-label-secondary">General</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($video['fld_status'] == 1): ?>
                          <span class="badge bg-label-success">Active</span>
                        <?php else: ?>
                          <span class="badge bg-label-danger">Inactive</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="https://www.youtube.com/watch?v=<?= $video['fld_video_id'] ?>" target="_blank">
                              <i class="bx bx-show me-1"></i> View
                            </a>
                            <a class="dropdown-item" href="<?= base_url('admin/youtube-videos/edit/' . $video['id']) ?>">
                              <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <a class="dropdown-item" href="<?= base_url('admin/youtube-videos/refresh/' . $video['id']) ?>">
                              <i class="bx bx-refresh me-1"></i> Refresh Data
                            </a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDelete(<?= $video['id'] ?>)">
                              <i class="bx bx-trash me-1"></i> Delete
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="9" class="text-center">No YouTube videos found</td>
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
        <p>Are you sure you want to delete this YouTube video?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" method="POST" action="">
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
        document.getElementById('deleteForm').action = '<?= base_url('admin/youtube-videos/delete/') ?>' + id;
        $('#deleteModal').modal('show');
    }
</script>
<?= $this->endSection() ?>