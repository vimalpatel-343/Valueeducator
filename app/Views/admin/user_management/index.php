<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12">
      <!-- User Statistics Cards -->
      <div class="row mb-4">
        <div class="col-lg-3 col-md-6 col-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="<?= base_url('assets/img/icons/unicons/user-icon.png') ?>" alt="total users" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt1">
                    <a class="dropdown-item" href="javascript:void(0);">View Details</a>
                    <a class="dropdown-item" href="javascript:void(0);">Export</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Total Users</p>
              <h4 class="card-title mb-3"><?= $stats['totalUsers'] ?></h4>
              <small class="text-muted fw-medium">
                <i class="icon-base bx bx-user"></i> Registered users
              </small>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="<?= base_url('assets/img/icons/unicons/chart-success.png') ?>" alt="active users" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
                    <a class="dropdown-item" href="javascript:void(0);">View Details</a>
                    <a class="dropdown-item" href="javascript:void(0);">Export</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Active Users</p>
              <h4 class="card-title mb-3" id="activeUsersCount"><?= $stats['activeUsers'] ?></h4>
              <small class="text-success fw-medium">
                <i class="icon-base bx bx-up-arrow-alt"></i> 
                <span id="activeUsersPercentage"><?= round(($stats['activeUsers'] / $stats['totalUsers']) * 100) ?>%</span> of total users
              </small>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="<?= base_url('assets/img/icons/unicons/cc-success.png') ?>" alt="subscribed users" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="javascript:void(0);">View Details</a>
                    <a class="dropdown-item" href="javascript:void(0);">Export</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Subscribed Users</p>
              <h4 class="card-title mb-3" id="subscribedUsersCount"><?= $stats['subscribedUsers'] ?></h4>
              <small class="text-info fw-medium">
                <i class="icon-base bx bx-credit-card"></i> 
                <span id="subscribedUsersPercentage"><?= round(($stats['subscribedUsers'] / $stats['totalUsers']) * 100) ?>%</span> conversion rate
              </small>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between mb-4">
                <div class="avatar flex-shrink-0">
                  <img src="<?= base_url('assets/img/icons/unicons/wallet.png') ?>" alt="total revenue" class="rounded">
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                    <a class="dropdown-item" href="javascript:void(0);">View Details</a>
                    <a class="dropdown-item" href="javascript:void(0);">Export</a>
                  </div>
                </div>
              </div>
              <p class="mb-1">Total Revenue</p>
              <h4 class="card-title mb-3" id="totalRevenue">₹<?= number_format($stats['totalRevenue'], 2) ?></h4>
              <small class="text-warning fw-medium">
                <i class="icon-base bx bx-dollar-circle"></i> 
                <span id="revenueGrowth">+12.5%</span> growth this month
              </small>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters and Search -->
      <div class="card mb-4">
        <div class="card-header border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">User Management</h5>
            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
              <i class="bx bx-plus me-1"></i> Add New User
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-text"><i class="bx bx-search"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Search by name, email, or mobile..." value="<?= $filters['search'] ?>">
              </div>
            </div>
            <div class="col-md-2">
              <select class="form-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="1" <?= $filters['status'] === '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $filters['status'] === '0' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
            <div class="col-md-2">
              <select class="form-select" id="subscriptionFilter">
                <option value="">All Users</option>
                <option value="subscribed" <?= $filters['subscription'] === 'subscribed' ? 'selected' : '' ?>>Subscribed</option>
                <option value="not_subscribed" <?= $filters['subscription'] === 'not_subscribed' ? 'selected' : '' ?>>Not Subscribed</option>
              </select>
            </div>
            <div class="col-md-2">
              <select class="form-select" id="perPageSelect">
                <?php foreach ($perPageOptions as $option): ?>
                  <option value="<?= $option ?>" <?= $perPage == $option ? 'selected' : '' ?>><?= $option ?> per page</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <button class="btn btn-secondary w-100" id="resetFilters">
                <i class="bx bx-reset me-1"></i> Reset
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- User List -->
      <div class="card">
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
          
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>KYC Status</th>
                  <th>Emerging Titans</th>
                  <th>Tiny Titans</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($users)): ?>
                  <?php foreach ($users as $user): ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="avatar me-3">
                            <?php if (!empty($user['fld_profile_image'])): ?>
                              <img src="<?= base_url($user['fld_profile_image']); ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            <?php else: ?>
                              <div class="avatar-initial rounded-circle bg-label-secondary">
                                <?= strtoupper(substr($user['fld_full_name'], 0, 1)) ?>
                              </div>
                            <?php endif; ?>
                          </div>
                          <div>
                            <h6 class="mb-0"><?= $user['fld_full_name'] ?></h6>
                            <small class="text-muted">ID: <?= $user['id'] ?></small>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-envelope text-muted me-2"></i>
                            <span><?= $user['fld_email'] ?></span>
                          </div>
                          <div class="d-flex align-items-center">
                            <i class="bx bx-phone text-muted me-2"></i>
                            <span><?= $user['fld_mobile'] ?></span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <?php if ($user['fld_status'] == 1): ?>
                          <span class="badge bg-label-success">Active</span>
                        <?php else: ?>
                          <span class="badge bg-label-danger">Inactive</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($user['fld_kyc_status'] == 1): ?>
                          <div class="kyc-status">
                            <div class="d-flex align-items-center mb-1">
                              <span class="badge bg-label-success me-2">KYC Done</span>
                              <div class="form-check form-switch">
                                <input class="form-check-input kyc-toggle" type="checkbox" role="switch" 
                                      data-user-id="<?= $user['id'] ?>" checked>
                              </div>
                            </div>
                            <div class="kyc-dates small text-muted">
                              <div>Start: <?= date('d M Y', strtotime($user['fld_kyc_start_date'])) ?></div>
                              <div>End: <?= date('d M Y', strtotime($user['fld_kyc_end_date'])) ?></div>
                              <?php 
                              $kycEndDate = new \DateTime($user['fld_kyc_end_date']);
                              $currentDate = new \DateTime();
                              $daysUntilKycExpiry = $currentDate->diff($kycEndDate)->days;
                              if ($daysUntilKycExpiry > 0) {
                                  echo '<div class="text-warning">Expires in ' . $daysUntilKycExpiry . ' days</div>';
                              } else {
                                  echo '<div class="text-danger">Expired</div>';
                              }
                              ?>
                            </div>
                          </div>
                        <?php else: ?>
                          <div class="kyc-status">
                            <div class="d-flex align-items-center mb-1">
                              <span class="badge bg-label-danger me-2">KYC Pending</span>
                              <div class="form-check form-switch">
                                <input class="form-check-input kyc-toggle" type="checkbox" role="switch" 
                                      data-user-id="<?= $user['id'] ?>">
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if (isset($user['productSubscriptions']['emerging-titans'])): ?>
                          <?php $sub = $user['productSubscriptions']['emerging-titans']; ?>
                          <div class="subscription-info">
                            <div class="d-flex align-items-center mb-1">
                              <i class="bx bx-check-circle text-success me-1"></i>
                              <span class="fw-bold">Subscribed</span>
                            </div>
                            <div class="subscription-dates small text-muted">
                              <div>Start: <?= date('d M Y', strtotime($sub['start_date'])) ?></div>
                              <div>End: <?= date('d M Y', strtotime($sub['end_date'])) ?></div>
                              <?php 
                              $endDate = new \DateTime($sub['end_date']);
                              $currentDate = new \DateTime();
                              $daysUntilExpiry = $currentDate->diff($endDate)->days;
                              if ($daysUntilExpiry > 0) {
                                  echo '<div class="text-warning">Expires in ' . $daysUntilExpiry . ' days</div>';
                              } else {
                                  echo '<div class="text-danger">Expired</div>';
                              }
                              ?>
                            </div>
                          </div>
                        <?php else: ?>
                          <span class="text-muted">Not subscribed</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if (isset($user['productSubscriptions']['tiny-titans'])): ?>
                          <?php $sub = $user['productSubscriptions']['tiny-titans']; ?>
                          <div class="subscription-info">
                            <div class="d-flex align-items-center mb-1">
                              <i class="bx bx-check-circle text-success me-1"></i>
                              <span class="fw-bold">Subscribed</span>
                            </div>
                            <div class="subscription-dates small text-muted">
                              <div>Start: <?= date('d M Y', strtotime($sub['start_date'])) ?></div>
                              <div>End: <?= date('d M Y', strtotime($sub['end_date'])) ?></div>
                              <?php 
                              $endDate = new \DateTime($sub['end_date']);
                              $currentDate = new \DateTime();
                              $daysUntilExpiry = $currentDate->diff($endDate)->days;
                              if ($daysUntilExpiry > 0) {
                                  echo '<div class="text-warning">Expires in ' . $daysUntilExpiry . ' days</div>';
                              } else {
                                  echo '<div class="text-danger">Expired</div>';
                              }
                              ?>
                            </div>
                          </div>
                        <?php else: ?>
                          <span class="text-muted">Not subscribed</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url('admin/users/edit/' . $user['id']) ?>">
                              <i class="bx bx-edit-alt me-1"></i> Edit
                            </a>
                            <?php if ($user['has_active_subscription']): ?>
                              <a class="dropdown-item" href="<?= base_url('admin/users/view-subscriptions/' . $user['id']) ?>">
                                <i class="bx bx-receipt me-1"></i> View Subscriptions
                              </a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="viewLoginHistory(<?= $user['id'] ?>, '<?= $user['fld_full_name'] ?>')">
                              <i class="bx bx-history me-1"></i> Login History
                            </a>
                            <?php if ($user['fld_role'] !== 'admin' && $user['fld_role'] !== 'superadmin'): ?>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete(<?= $user['id'] ?>)">
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
                    <td colspan="7" class="text-center py-5">
                      <div class="text-center">
                        <i class="bx bx-user-x" style="font-size: 48px; color: #ccc;"></i>
                        <h5 class="mt-3">No users found</h5>
                        <p class="text-muted">Try adjusting your search or filter criteria</p>
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          
          <!-- Improved Pagination -->
          <?php if ($pagination['totalPages'] > 1): ?>
              <div class="d-flex justify-content-between align-items-center mt-4">
                  <div>
                      Showing <?= ($pagination['currentPage'] - 1) * $pagination['perPage'] + 1 ?> to 
                      <?= min($pagination['currentPage'] * $pagination['perPage'], $pagination['total']) ?> 
                      of <?= $pagination['total'] ?> users
                  </div>
                  <nav aria-label="Page navigation">
                      <ul class="pagination mb-0">
                          <?php if ($pagination['prevUrl']): ?>
                              <li class="page-item">
                                  <a class="page-link" href="<?= $pagination['prevUrl'] ?>">
                                      <i class="bx bx-chevron-left"></i>
                                  </a>
                              </li>
                          <?php endif; ?>
                          
                          <?php
                          // Calculate the range of page numbers to show
                          $currentPage = $pagination['currentPage'];
                          $totalPages = $pagination['totalPages'];
                          $maxVisiblePages = 7;
                          
                          // Always show first page
                          if ($currentPage > 1) {
                              echo '<li class="page-item"><a class="page-link" href="' . $pagination['urls'][1] . '">1</a></li>';
                              
                              // Show ellipsis if needed
                              if ($currentPage > 3) {
                                  echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                              }
                          }
                          
                          // Calculate range
                          $startPage = max(2, $currentPage - 2);
                          $endPage = min($totalPages - 1, $currentPage + 2);
                          
                          // Adjust range if we're near the beginning
                          if ($currentPage <= 3) {
                              $endPage = min($totalPages - 1, 5);
                          }
                          
                          // Adjust range if we're near the end
                          if ($currentPage >= $totalPages - 2) {
                              $startPage = max(2, $totalPages - 5);
                          }
                          
                          // Show page numbers in range
                          for ($i = $startPage; $i <= $endPage; $i++) {
                              if ($i == $currentPage) {
                                  echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                              } else {
                                  echo '<li class="page-item"><a class="page-link" href="' . $pagination['urls'][$i] . '">' . $i . '</a></li>';
                              }
                          }
                          
                          // Always show last page
                          if ($currentPage < $totalPages) {
                              // Show ellipsis if needed
                              if ($currentPage < $totalPages - 2) {
                                  echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                              }
                              
                              echo '<li class="page-item"><a class="page-link" href="' . $pagination['urls'][$totalPages] . '">' . $totalPages . '</a></li>';
                          }
                          ?>
                          
                          <?php if ($pagination['nextUrl']): ?>
                              <li class="page-item">
                                  <a class="page-link" href="<?= $pagination['nextUrl'] ?>">
                                      <i class="bx bx-chevron-right"></i>
                                  </a>
                              </li>
                          <?php endif; ?>
                      </ul>
                  </nav>
              </div>
          <?php endif; ?>
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
        <p>Are you sure you want to delete this user?</p>
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

<!-- Login History Modal -->
<div class="modal fade" id="loginHistoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="loginHistoryContent">
          <!-- Login history will be loaded here -->
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  $(document).ready(function() {
    // Add hover effects to cards
    $('.card').hover(
      function() {
        $(this).addClass('shadow-lg');
      },
      function() {
        $(this).removeClass('shadow-lg');
      }
    );
    
    // Filter functionality
    function applyFilters() {
      const search = $('#searchInput').val();
      const status = $('#statusFilter').val();
      const subscription = $('#subscriptionFilter').val();
      const perPage = $('#perPageSelect').val();
      
      let url = '<?= base_url('admin/users') ?>?';
      const params = [];
      
      if (search) params.push('search=' + encodeURIComponent(search));
      if (status !== '') params.push('status=' + status);
      if (subscription) params.push('subscription=' + subscription);
      params.push('per_page=' + perPage);
      
      url += params.join('&');
      
      window.location.href = url;
    }
    
    // Apply filters on change
    $('#searchInput, #statusFilter, #subscriptionFilter').on('change keyup', function(e) {
      if (e.type === 'keyup' && e.keyCode !== 13) return;
      applyFilters();
    });
    
    // Handle per page change
    $('#perPageSelect').on('change', function() {
      applyFilters();
    });
    
    // Reset filters
    $('#resetFilters').on('click', function() {
      window.location.href = '<?= base_url('admin/users') ?>';
    });
    
    // Search on Enter key
    $('#searchInput').on('keypress', function(e) {
      if (e.which === 13) {
        applyFilters();
      }
    });

    // KYC Toggle
    $(document).on('change', '.kyc-toggle', function() {
        const userId = $(this).data('user-id');
        const kycStatus = $(this).is(':checked') ? 1 : 0;
        
        $.ajax({
            url: '<?= base_url('admin/users/update-kyc-status') ?>',
            type: 'POST',
            data: {
                user_id: userId,
                kyc_status: kycStatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    toastr.success(response.message);
                    // Reload the page to show updated KYC status
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    // Revert the toggle and show error
                    $(this).prop('checked', !kycStatus);
                    toastr.error(response.message);
                }
            },
            error: function() {
                // Revert the toggle and show error
                $(this).prop('checked', !kycStatus);
                toastr.error('Error updating KYC status. Please try again.');
            }
        });
    });
    
  });
  
  function confirmDelete(id) {
    document.getElementById('deleteForm').action = '<?= base_url('admin/users/delete/') ?>' + id;
    $('#deleteModal').modal('show');
  }
  
  function viewLoginHistory(userId, userName) {
    $('#loginHistoryModal .modal-title').text('Login History - ' + userName);
    $('#loginHistoryContent').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
    $('#loginHistoryModal').modal('show');
    
    // Load login history via AJAX
    $.ajax({
      url: '<?= base_url('admin/users/get-login-history/') ?>' + userId,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success && response.loginHistory.length > 0) {
          let html = '<div class="table-responsive"><table class="table table-hover"><thead><tr><th>Login Time</th><th>IP Address</th><th>Device Type</th><th>Browser</th><th>User Agent</th></tr></thead><tbody>';
          
          response.loginHistory.forEach(function(login) {
            html += '<tr>';
            html += '<td>' + login.fld_login_time + '</td>';
            html += '<td>' + login.fld_ip_address + '</td>';
            html += '<td>' + login.fld_device_type + '</td>';
            html += '<td>' + login.fld_browser + '</td>';
            html += '<td><small>' + login.fld_user_agent + '</small></td>';
            html += '</tr>';
          });
          
          html += '</tbody></table></div>';
          $('#loginHistoryContent').html(html);
        } else {
          $('#loginHistoryContent').html('<div class="text-center py-5"><i class="bx bx-history" style="font-size: 48px; color: #ccc;"></i><h5 class="mt-3">No login history found</h5></div>');
        }
      },
      error: function() {
        $('#loginHistoryContent').html('<div class="alert alert-danger">Error loading login history. Please try again.</div>');
      }
    });
  }
</script>
<style>
/* Card styles */
.card {
  border-radius: 0.5rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  border: none;
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-body {
  padding: 1.5rem;
}

.card-title {
  font-weight: 600;
  line-height: 1.2;
}

.card-title h4 {
  font-size: 1.75rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.card-title p {
  font-size: 0.875rem;
  font-weight: 500;
  color: #6c757d;
  margin-bottom: 0;
}

.card-title small {
  font-size: 0.75rem;
  font-weight: 500;
}

.card-title .avatar img {
  width: 2rem;
  height: 2rem;
}

.dropdown-toggle::after {
  display: none;
}

/* Icon styles */
.icon-base {
  font-size: 1.2rem;
  vertical-align: middle;
}

.text-success {
  color: #71dd37 !important;
}

.text-info {
  color: #03c3ec !important;
}

.text-warning {
  color: #ffab00 !important;
}

.text-muted {
  color: #a3a4cc !important;
}

.card-title .avatar img {
  width: 70px !important;
  height: 50px !important;
}

/* KYC Status Styles */
.kyc-status {
  display: flex;
  flex-direction: column;
}

.kyc-dates {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

/* Subscription Info Styles */
.subscription-info {
  display: flex;
  flex-direction: column;
}

.subscription-dates {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

/* Pagination Styles */
.pagination {
  margin-bottom: 0;
}

.page-item.active .page-link {
  background-color: #696cff;
  border-color: #696cff;
}

.page-link {
  color: #696cff;
}

.page-link:hover {
  color: #5a5ed8;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .card-body {
    padding: 1rem;
  }
  
  .card-title h4 {
    font-size: 1.5rem;
  }
  
  .col-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  
  .table-responsive {
    font-size: 0.875rem;
  }
  
  .subscription-dates, .kyc-dates {
    font-size: 0.75rem;
  }
}
</style>
<?= $this->endSection() ?>