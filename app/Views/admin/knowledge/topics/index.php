<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Knowledge Centre /</span> Topics</h4>
    
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

    <!-- Topics Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Topics List</h5>
                <a href="<?= base_url('admin/knowledge-centre/create-topic') ?>" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Add New Topic
                </a>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-topics table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Sector</th>
                        <th>Icon</th>
                        <th>Description</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topics as $topic): ?>
                    <tr>
                        <td><?= $topic['id'] ?></td>
                        <td><?= $topic['name'] ?></td>
                        <td>
                            <?php if (!empty($topic['sector_name'])): ?>
                                <span class="badge bg-label-primary"><?= $topic['sector_name'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-label-secondary">No Sector</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($topic['icon'])): ?>
                                <img src="<?= base_url($topic['icon']) ?>" alt="Icon" width="40" height="40">
                            <?php else: ?>
                                <span class="badge bg-label-secondary">No Icon</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $desc = strip_tags($topic['description']);
                            echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                            ?>
                        </td>
                        <td><?= $topic['sort_order'] ?></td>
                        <td>
                            <?php if ($topic['active']): ?>
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
                                    <a class="dropdown-item" href="<?= base_url('admin/knowledge-centre/edit-topic/'.$topic['id']) ?>">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <a class="dropdown-item delete-topic" href="javascript:void(0)" data-id="<?= $topic['id'] ?>">
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
                    <?= $pager->links('default', 'custom_pagination') ?>
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
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this topic? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="post" action="" style="display: inline;">
                    <?= csrf_field() ?>
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
    $('.delete-topic').on('click', function() {
        var topicId = $(this).data('id');
        $('#deleteForm').attr('action', '<?= base_url('admin/knowledge-centre/delete-topic/') ?>' + topicId);
        $('#deleteModal').modal('show');
    });
});
</script>
<?= $this->endSection() ?>