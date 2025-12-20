<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Product Management</h4>
    
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
    
    <!-- Products Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">All Products</h5>
                <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Add Product
                </a>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-products table border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Market Cap Focus</th>
                        <th>Ideas/Year</th>
                        <th>Holding Period</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['fld_title'] ?></td>
                        <td><?= $product['fld_market_cap_focus'] ?></td>
                        <td><?= $product['fld_no_of_ideas'] ?></td>
                        <td><?= $product['fld_holding_period'] ?></td>
                        <td>₹<?= number_format($product['fld_pricing'], 2) ?></td>
                        <td>
                            <span class="badge bg-<?= $product['fld_status'] ? 'success' : 'danger' ?>">
                                <?= $product['fld_status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= base_url('admin/products/edit/' . $product['id']) ?>">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="confirmDelete(<?= $product['id'] ?>)">
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

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        window.location.href = '<?= base_url('admin/products/delete/') ?>' + id;
    }
}
</script>
<?= $this->endSection() ?>