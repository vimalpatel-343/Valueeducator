<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Welcome, <?= session()->get('userName') ?>! 🎉</h5>
              <p class="mb-4">
                This is your Value Educator admin dashboard. Here you can manage all aspects of your investment advisory platform.
              </p>
              <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-primary">Manage Products</a>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="<?= base_url('assets/img/illustrations/man-with-laptop-light.png') ?>" height="140" alt="View Badge User">
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="col-lg-3 col-md-6 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Total Users</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2"><?= $userCount ?></h4>
              </div>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-user"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Products</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2"><?= $productCount ?></h4>
              </div>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-success">
                <i class="bx bx-package"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Stocks</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2"><?= $stockCount ?></h4>
              </div>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-info">
                <i class="bx bx-line-chart"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Videos</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2"><?= $videoCount ?></h4>
              </div>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-danger">
                <i class="bx bx-video"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Recent Users -->
    <div class="col-lg-4 mb-4">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Recent Users</h5>
        </div>
        <div class="card-body">
          <ul class="mt-4 p-0">
            <?php foreach($recentUsers as $user): ?>
            <li class="d-flex mb-4 pb-2">
              <div class="avatar flex-shrink-0 me-3">
                <img src="<?= base_url('assets/img/avatars/1.png') ?>" alt="User" class="rounded" />
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0"><?= $user['fld_full_name'] ?></h6>
                  <small class="text-muted"><?= $user['fld_email'] ?></small>
                </div>
                <div class="user-progress">
                  <small class="text-muted"><?= date('M d, Y', strtotime($user['fld_created_at'])) ?></small>
                </div>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Recent Products -->
    <div class="col-lg-4 mb-4">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Recent Products</h5>
        </div>
        <div class="card-body">
          <ul class="mt-4 p-0">
            <?php foreach($recentProducts as $product): ?>
            <li class="d-flex mb-4 pb-2">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary">
                  <i class="bx bx-package"></i>
                </span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0"><?= $product['fld_title'] ?></h6>
                  <small class="text-muted"><?= $product['fld_market_cap_focus'] ?></small>
                </div>
                <div class="user-progress">
                  <small class="text-muted"><?= date('M d, Y', strtotime($product['fld_created_at'])) ?></small>
                </div>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Recent Stocks -->
    <div class="col-lg-4 mb-4">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Recent Stocks</h5>
        </div>
        <div class="card-body">
          <ul class="mt-4 p-0">
            <?php foreach($recentStocks as $stock): ?>
            <li class="d-flex mb-4 pb-2">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-info">
                  <i class="bx bx-line-chart"></i>
                </span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0"><?= $stock['fld_stock_name'] ?></h6>
                  <small class="text-muted"><?= $stock['fld_sector'] ?></small>
                </div>
                <div class="user-progress">
                  <small class="text-muted"><?= date('M d, Y', strtotime($stock['fld_created_at'])) ?></small>
                </div>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Recent Videos -->
    <div class="col-lg-12 mb-4">
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Recent Videos</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Video ID</th>
                  <th>Views</th>
                  <th>Posted Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($recentVideos as $video): ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar-wrapper">
                        <div class="avatar avatar me-2">
                          <span class="avatar-initial rounded bg-label-danger">
                            <i class="bx bx-video"></i>
                          </span>
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <span class="fw-semibold d-block"><?= $video['fld_title'] ?></span>
                      </div>
                    </div>
                  </td>
                  <td><?= $video['fld_video_id'] ?></td>
                  <td><?= number_format($video['fld_total_views']) ?></td>
                  <td><?= date('M d, Y', strtotime($video['fld_posted_at'])) ?></td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="https://www.youtube.com/watch?v=<?= $video['fld_video_id'] ?>" target="_blank">
                          <i class="bx bx-show me-1"></i> View
                        </a>
                        <a class="dropdown-item" href="<?= base_url('admin/youtube-videos/edit/'.$video['id']) ?>">
                          <i class="bx bx-edit-alt me-1"></i> Edit
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  $(document).ready(function() {
    // Any dashboard-specific JavaScript can go here
  });
</script>
<?= $this->endSection() ?>