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
          
          <form action="<?= base_url('admin/investment-philosophy/update/' . $philosophy['id']) ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $philosophy['fld_title']) ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="1" <?= old('status', $philosophy['fld_status']) == '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= old('status', $philosophy['fld_status']) == '0' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="form-group mb-3">
              <label for="image" class="form-label">Main Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*">
              <small class="text-muted">Recommended size: 500x300px</small>
              <?php if (!empty($philosophy['fld_image'])): ?>
                <div class="mt-2">
                  <img src="<?= base_url($philosophy['fld_image']) ?>" alt="<?= $philosophy['fld_title'] ?>" class="rounded" width="100" height="100">
                </div>
              <?php endif; ?>
            </div>
            
            <div class="form-group mb-3">
              <label class="form-label">Additional Images (Max 3)</label>
              <div class="row">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                  <div class="col-md-4 mb-3">
                    <div class="image-upload-box">
                      <label class="form-label">Image <?= $i ?></label>
                      <?php if (isset($philosophy['images'][$i-1])): ?>
                        <div class="mb-2">
                          <img src="<?= base_url($philosophy['images'][$i-1]['image_path']) ?>" alt="Image <?= $i ?>" class="rounded" width="100" height="100">
                          <button type="button" class="btn btn-sm btn-danger ms-2 delete-existing-image" data-image-id="<?= $philosophy['images'][$i-1]['id'] ?>">Delete</button>
                        </div>
                      <?php endif; ?>
                      <input type="file" class="form-control" name="images[]" accept="image/*">
                    </div>
                  </div>
                <?php endfor; ?>
              </div>
            </div>
            
            <div class="form-group mb-3">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" id="description" name="description" rows="5" required><?= old('description', $philosophy['fld_description']) ?></textarea>
            </div>
            
            <div class="form-group mb-3">
              <label class="form-label">Service Details</label>
              <div id="serviceContainer">
                <?php if (!empty($philosophy['services'])): ?>
                  <?php foreach ($philosophy['services'] as $service): ?>
                    <div class="service-row mb-3 p-3 border rounded">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-label">Icon Name <small>(Material Icons)</small></label>
                            <input type="text" class="form-control" name="service_icon[]" value="<?= old('service_icon[]', $service['icon_name']) ?>" placeholder="e.g., star, check_circle, etc.">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-label">Service Title</label>
                            <input type="text" class="form-control" name="service_title[]" value="<?= old('service_title[]', $service['service_title']) ?>" placeholder="Service title">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-label">Service Description</label>
                            <textarea class="form-control" name="service_description[]" rows="2" placeholder="Short description"><?= old('service_description[]', $service['service_description']) ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-danger remove-service">Remove</button>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
                
                <!-- Add one empty service row if none exist -->
                <?php if (empty($philosophy['services'])): ?>
                  <div class="service-row mb-3 p-3 border rounded">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Icon Name <small>(Material Icons)</small></label>
                          <input type="text" class="form-control" name="service_icon[]" placeholder="e.g., star, check_circle, etc.">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Service Title</label>
                          <input type="text" class="form-control" name="service_title[]" placeholder="Service title">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Service Description</label>
                          <textarea class="form-control" name="service_description[]" rows="2" placeholder="Short description"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="text-end mt-2">
                      <button type="button" class="btn btn-sm btn-danger remove-service">Remove</button>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" id="addServiceBtn" class="btn btn-sm btn-outline-primary">Add More Service</button>
            </div>
            
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('admin/investment-philosophy') ?>" class="btn btn-label-secondary me-2">Cancel</a>
              <button type="submit" class="btn btn-primary">Update</button>
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
  document.addEventListener('DOMContentLoaded', function() {
    // Add more service rows
    document.getElementById('addServiceBtn').addEventListener('click', function() {
      const serviceContainer = document.getElementById('serviceContainer');
      const serviceRow = document.createElement('div');
      serviceRow.className = 'service-row mb-3 p-3 border rounded';
      serviceRow.innerHTML = `
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Icon Name <small>(Material Icons)</small></label>
              <input type="text" class="form-control" name="service_icon[]" placeholder="e.g., star, check_circle, etc.">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Service Title</label>
              <input type="text" class="form-control" name="service_title[]" placeholder="Service title">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Service Description</label>
              <textarea class="form-control" name="service_description[]" rows="2" placeholder="Short description"></textarea>
            </div>
          </div>
        </div>
        <div class="text-end mt-2">
          <button type="button" class="btn btn-sm btn-danger remove-service">Remove</button>
        </div>
      `;
      serviceContainer.appendChild(serviceRow);
      
      // Add event listener to remove button
      serviceRow.querySelector('.remove-service').addEventListener('click', function() {
        serviceRow.remove();
      });
    });
    
    // Remove service row
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-service')) {
        e.target.closest('.service-row').remove();
      }
    });
    
    // Delete existing image
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('delete-existing-image')) {
        if (confirm('Are you sure you want to delete this image?')) {
          const imageId = e.target.getAttribute('data-image-id');
          const philosophyId = <?= $philosophy['id'] ?>;
          
          fetch(`/admin/investment-philosophy/delete-image/${philosophyId}/${imageId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Remove the image preview and delete button
              const imageBox = e.target.closest('.image-upload-box');
              const imagePreview = imageBox.querySelector('div');
              if (imagePreview) {
                imagePreview.remove();
              }
              e.target.remove();
            } else {
              alert('Failed to delete image');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete image');
          });
        }
      }
    });
  });
</script>
<?= $this->endSection() ?>