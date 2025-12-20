<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><?= $title ?></h5>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
              <i class="bx bx-arrow-back me-1"></i> Back to Users
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">User Information</h5>
                  <table class="table table-borderless">
                    <tr>
                      <td><strong>Name:</strong></td>
                      <td><?= $user['fld_full_name'] ?></td>
                    </tr>
                    <tr>
                      <td><strong>Email:</strong></td>
                      <td><?= $user['fld_email'] ?></td>
                    </tr>
                    <tr>
                      <td><strong>Mobile:</strong></td>
                      <td><?= $user['fld_mobile'] ?></td>
                    </tr>
                    <tr>
                      <td><strong>Role:</strong></td>
                      <td>
                        <span class="badge bg-label-<?= $user['fld_role'] === 'superadmin' ? 'danger' : ($user['fld_role'] === 'admin' ? 'warning' : 'info') ?>">
                          <?= ucfirst($user['fld_role']) ?>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Status:</strong></td>
                      <td>
                        <?php if ($user['fld_status'] == 1): ?>
                          <span class="badge bg-label-success">Active</span>
                        <?php else: ?>
                          <span class="badge bg-label-danger">Inactive</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Subscription Summary</h5>
                  <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                      <div class="text-center">
                        <h3 class="mb-0"><?= count($subscriptions) ?></h3>
                        <p class="mb-0">Total Subscriptions</p>
                      </div>
                    </div>
                    <div class="me-3">
                      <div class="text-center">
                        <h3 class="mb-0">
                          <?php 
                            $totalAmount = 0;
                            foreach ($subscriptions as $subscription) {
                              $totalAmount += $subscription['amount'];
                            }
                            echo '₹' . number_format($totalAmount, 2);
                          ?>
                        </h3>
                        <p class="mb-0">Total Amount</p>
                      </div>
                    </div>
                    <div>
                      <div class="text-center">
                        <h3 class="mb-0">
                          <?php 
                            $activeCount = 0;
                            foreach ($subscriptions as $subscription) {
                              if ($subscription['status'] == 1 && $subscription['end_date'] >= date('Y-m-d')) {
                                $activeCount++;
                              }
                            }
                            echo $activeCount;
                          ?>
                        </h3>
                        <p class="mb-0">Active Subscriptions</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Subscription Details</h5>
            </div>
            <div class="card-body">
              <?php if (!empty($subscriptions)): ?>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Subscription Type</th>
                        <th>Amount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Days Left</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($subscriptions as $subscription): ?>
                        <tr>
                          <td><?= $subscription['product']['fld_title'] ?></td>
                          <td><?= ucfirst($subscription['subscription_type']) ?></td>
                          <td>₹<?= number_format($subscription['amount'], 2) ?></td>
                          <td><?= date('M d, Y', strtotime($subscription['start_date'])) ?></td>
                          <td><?= date('M d, Y', strtotime($subscription['end_date'])) ?></td>
                          <td>
                            <?php if ($subscription['status'] == 1 && $subscription['end_date'] >= date('Y-m-d')): ?>
                              <span class="badge bg-label-success">Active</span>
                            <?php else: ?>
                              <span class="badge bg-label-danger">Expired</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php 
                              if ($subscription['status'] == 1 && $subscription['end_date'] >= date('Y-m-d')) {
                                $endDate = new \DateTime($subscription['end_date']);
                                $currentDate = new \DateTime();
                                $interval = $currentDate->diff($endDate);
                                echo $interval->days;
                              } else {
                                echo 'Expired';
                              }
                            ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php else: ?>
                <div class="text-center py-5">
                  <img src="images/subscription.svg" alt="No Subscriptions" class="mb-3" style="width: 80px; opacity: 0.5;">
                  <h5>No Subscriptions Found</h5>
                  <p class="text-muted">This user doesn't have any subscriptions yet.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>