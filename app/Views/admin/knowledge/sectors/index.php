<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Knowledge Centre /</span> Sectors</h4>
    
    <!-- Alerts -->
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Sectors Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Sectors List</h5>
                <a href="<?= base_url('admin/knowledge-centre/create-sector') ?>" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Add New Sector
                </a>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-sectors table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Icon</th>
                        <th>Used For</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sectors as $sector): ?>
                    <tr>
                        <td><?= $sector['id'] ?></td>
                        <td><?= $sector['name'] ?></td>
                        <td>
                            <?php if (!empty($sector['image'])): ?>
                                <img src="<?= base_url($sector['image']) ?>" alt="Image" width="50" height="50">
                            <?php else: ?>
                                <span class="badge bg-label-secondary">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($sector['icon'])): ?>
                                <img src="<?= base_url($sector['icon']) ?>" alt="Icon" width="30" height="30">
                            <?php else: ?>
                                <span class="badge bg-label-secondary">No Icon</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $usedFor = '';
                            switch($sector['used_for']) {
                                case 1: $usedFor = 'Knowledge Sector'; break;
                                case 2: $usedFor = 'Report'; break;
                                case 3: $usedFor = 'Other'; break;
                            }
                            echo $usedFor;
                            ?>
                        </td>
                        <td><?= $sector['sort_order'] ?></td>
                        <td>
                            <?php if ($sector['active']): ?>
                                <span class="badge bg-label-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-label-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= base_url('admin/knowledge-centre/edit-sector/'.$sector['id']) ?>">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <a class="dropdown-item delete-sector" href="javascript:void(0)" data-id="<?= $sector['id'] ?>">
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
        <div class="card-footer">
           <?php if ($pager->getPageCount() > 1): ?>
                <div class="mt-4">
                    <?= $pager->links('default', 'Pagers/custom_pagination') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this sector? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="get" action="">
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
 $(document).ready(function() {
    $('.delete-sector').on('click', function() {
        var sectorId = $(this).data('id');
        $('#deleteForm').attr('action', '<?= base_url('admin/knowledge-centre/delete-sector/') ?>' + sectorId);
        $('#deleteModal').modal('show');
    });
});
</script>
<?= $this->endSection() ?>