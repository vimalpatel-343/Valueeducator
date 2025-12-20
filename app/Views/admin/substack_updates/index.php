<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Substack Updates</h5>
                        <a href="<?= base_url('admin/substack-updates/create') ?>" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Add Update
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Alerts -->
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
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Products</th>
                                    <th>Posted At</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Get updates with product names
                                $substackUpdateModel = new \App\Models\SubstackUpdateModel();
                                $updatesWithNames = $substackUpdateModel->getUpdatesWithProductNames();
                                ?>
                                <?php foreach ($updatesWithNames as $update): ?>
                                <tr>
                                    <td><?= $update['id'] ?></td>
                                    <td><?= $update['fld_title'] ?></td>
                                    <td><?= !empty($update['product_names']) ? $update['product_names'] : 'N/A' ?></td>
                                    <td><?= date('d M Y', strtotime($update['fld_posted_at'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $update['fld_status'] ? 'success' : 'danger' ?>">
                                            <?= $update['fld_status'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('admin/substack-updates/edit/' . $update['id']) ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDelete(<?= $update['id'] ?>)">
                                                    <i class="bx bx-trash me-1"></i> Delete
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
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this update?')) {
        window.location.href = '<?= base_url('admin/substack-updates/delete/') ?>' + id;
    }
}
</script>
<?= $this->endSection() ?>