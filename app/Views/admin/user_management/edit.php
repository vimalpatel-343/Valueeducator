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
          
          <form action="<?= base_url('admin/users/update/' . $user['id']) ?>" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name', $user['fld_full_name']) ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['fld_email']) ?>" required>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile" value="<?= old('mobile', $user['fld_mobile']) ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                  <input type="password" class="form-control" id="password" name="password">
                </div>
              </div>
            </div>
            
            <div class="form-group mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" id="address" name="address" rows="3"><?= old('address', $user['fld_address']) ?></textarea>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="1" <?= old('status', $user['fld_status']) == '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= old('status', $user['fld_status']) == '0' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                  <select class="form-select" id="role" name="role" required>
                    <option value="user" <?= old('role', $user['fld_role']) == 'user' ? 'selected' : '' ?>>User</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('admin/users') ?>" class="btn btn-label-secondary me-2">Cancel</a>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- KYC Management Section -->
  <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header border-bottom">
            <h5 class="card-title mb-0">KYC Management</h5>
          </div>
          <div class="card-body">
            <form id="kycForm">
              <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="kyc_status" class="form-label">KYC Status</label>
                    <select class="form-select" id="kyc_status" name="kyc_status">
                      <option value="0" <?= $user['fld_kyc_status'] == 0 ? 'selected' : '' ?>>Not Verified</option>
                      <option value="1" <?= $user['fld_kyc_status'] == 1 ? 'selected' : '' ?>>Verified</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="kyc_start_date" class="form-label">KYC Start Date</label>
                    <input type="date" class="form-control" id="kyc_start_date" name="kyc_start_date" value="<?= $user['fld_kyc_start_date'] ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="kyc_end_date" class="form-label">KYC End Date</label>
                    <input type="date" class="form-control" id="kyc_end_date" name="kyc_end_date" value="<?= $user['fld_kyc_end_date'] ?>">
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update KYC</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Subscription Management Section -->
    <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Subscription Management</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">
              Add Subscription
            </button>
          </div>
          <div class="card-body">
            <?php if (!empty($subscriptions)): ?>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Subscription Type</th>
                      <th>Amount</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($subscriptions as $subscription): ?>
                      <tr>
                        <td><?= $subscription['fld_title'] ?></td>
                        <td><?= ucfirst($subscription['subscription_type']) ?></td>
                        <td><?= $subscription['amount'] ?></td>
                        <td><?= $subscription['start_date'] ?></td>
                        <td><?= $subscription['end_date'] ?></td>
                        <td><?= $subscription['status'] ? 'Active' : 'Inactive' ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-info edit-subscription" 
                                  data-subscription-id="<?= $subscription['id'] ?>"
                                  data-start-date="<?= $subscription['start_date'] ?>"
                                  data-end-date="<?= $subscription['end_date'] ?>"
                                  data-status="<?= $subscription['status'] ?>">
                            Edit Dates
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <p>No subscriptions found for this user.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Add Subscription Modal -->
<div class="modal fade" id="addSubscriptionModal" tabindex="-1" aria-labelledby="addSubscriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSubscriptionModalLabel">Add Subscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addSubscriptionForm">
          <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
          <div class="form-group mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select class="form-select" id="product_id" name="product_id" required>
              <option value="">Select Product</option>
              <?php foreach ($products as $product): ?>
                <option value="<?= $product['id'] ?>"><?= $product['fld_title'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="subscription_type" class="form-label">Subscription Type</label>
            <select class="form-select" id="subscription_type" name="subscription_type" required>
              <!-- <option value="monthly">Monthly</option>
              <option value="quarterly">Quarterly</option> -->
              <option value="yearly">Yearly</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveSubscription">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Subscription Modal -->
<div class="modal fade" id="editSubscriptionModal" tabindex="-1" aria-labelledby="editSubscriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSubscriptionModalLabel">Edit Subscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editSubscriptionForm">
          <input type="hidden" name="subscription_id" id="edit_subscription_id">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="edit_start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="edit_end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="edit_status" class="form-label">Status</label>
            <select class="form-select" id="edit_status" name="status" required>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="updateSubscription">Update</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // Function to add one year to a date
  function addOneYear(dateString) {
    const date = new Date(dateString);
    date.setFullYear(date.getFullYear() + 1);
    return date.toISOString().split('T')[0];
  }

  // Handle KYC form submission
  document.getElementById('kycForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= base_url('admin/users/updateKycStatus') ?>', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('KYC status updated successfully');
        location.reload();
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while updating KYC status');
    });
  });

  // When KYC start date changes, set end date to +1 year
  document.getElementById('kyc_start_date').addEventListener('change', function() {
    const startDate = this.value;
    if (startDate) {
      document.getElementById('kyc_end_date').value = addOneYear(startDate);
    }
  });

  // Handle add subscription form
  document.getElementById('saveSubscription').addEventListener('click', function() {
    const form = document.getElementById('addSubscriptionForm');
    const formData = new FormData(form);
    
    fetch('<?= base_url('admin/users/addSubscription') ?>', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Subscription added successfully');
        location.reload();
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while adding subscription');
    });
  });

  // When product is selected, fetch the product price and set it in the amount field
  document.getElementById('product_id').addEventListener('change', function() {
    const productId = this.value;
    if (productId) {
      // Fetch product details via AJAX
      fetch(`<?= base_url('admin/users/getProductPrice/') ?>${productId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('amount').value = data.price;
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  });

  // When subscription start date changes, set end date to +1 year
  document.getElementById('start_date').addEventListener('change', function() {
    const startDate = this.value;
    if (startDate) {
      document.getElementById('end_date').value = addOneYear(startDate);
    }
  });

  // Handle edit subscription button
  document.querySelectorAll('.edit-subscription').forEach(button => {
    button.addEventListener('click', function() {
      const subscriptionId = this.getAttribute('data-subscription-id');
      const startDate = this.getAttribute('data-start-date');
      const endDate = this.getAttribute('data-end-date');
      const status = this.getAttribute('data-status');
      
      document.getElementById('edit_subscription_id').value = subscriptionId;
      document.getElementById('edit_start_date').value = startDate;
      document.getElementById('edit_end_date').value = endDate;
      document.getElementById('edit_status').value = status;
      
      const modal = new bootstrap.Modal(document.getElementById('editSubscriptionModal'));
      modal.show();
    });
  });

  // When edit subscription start date changes, set end date to +1 year
  document.getElementById('edit_start_date').addEventListener('change', function() {
    const startDate = this.value;
    if (startDate) {
      document.getElementById('edit_end_date').value = addOneYear(startDate);
    }
  });

  // Handle update subscription form
  document.getElementById('updateSubscription').addEventListener('click', function() {
    const form = document.getElementById('editSubscriptionForm');
    const formData = new FormData(form);
    
    fetch('<?= base_url('admin/users/updateSubscription') ?>', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Subscription updated successfully');
        location.reload();
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while updating subscription');
    });
  });
</script>
<?= $this->endSection() ?>