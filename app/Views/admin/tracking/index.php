<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">UTM Tracking Data</h1>
        <div>
            <a href="<?= base_url('/admin/tracking/statistics') ?>" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> View Statistics
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form method="get" action="<?= base_url('/admin/tracking') ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label for="source" class="form-label">Source</label>
                        <select name="source" id="source" class="form-select">
                            <option value="">All Sources</option>
                            <?php foreach ($sources as $source): ?>
                                <option value="<?= $source['source'] ?>" <?= isset($filters['source']) && $filters['source'] == $source['source'] ? 'selected' : '' ?>>
                                    <?= $source['source'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="medium" class="form-label">Medium</label>
                        <select name="medium" id="medium" class="form-select">
                            <option value="">All Mediums</option>
                            <?php foreach ($mediums as $medium): ?>
                                <option value="<?= $medium['medium'] ?>" <?= isset($filters['medium']) && $filters['medium'] == $medium['medium'] ? 'selected' : '' ?>>
                                    <?= $medium['medium'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="utm_campaign" class="form-label">Campaign</label>
                        <select name="utm_campaign" id="utm_campaign" class="form-select">
                            <option value="">All Campaigns</option>
                            <?php foreach ($campaigns as $campaign): ?>
                                <option value="<?= $campaign['utm_campaign'] ?>" <?= isset($filters['utm_campaign']) && $filters['utm_campaign'] == $campaign['utm_campaign'] ? 'selected' : '' ?>>
                                    <?= $campaign['utm_campaign'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="is_converted" class="form-label">Conversion Status</label>
                        <select name="is_converted" id="is_converted" class="form-select">
                            <option value="">All</option>
                            <option value="1" <?= isset($filters['is_converted']) && $filters['is_converted'] == '1' ? 'selected' : '' ?>>Converted</option>
                            <option value="0" <?= isset($filters['is_converted']) && $filters['is_converted'] == '0' ? 'selected' : '' ?>>Not Converted</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="<?= isset($filters['date_from']) ? $filters['date_from'] : '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="<?= isset($filters['date_to']) ? $filters['date_to'] : '' ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="<?= base_url('/admin/tracking') ?>" class="btn btn-secondary ms-2">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Per Page Dropdown -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="input-group" style="width: 200px;">
                <label class="input-group-text" for="per_page">Per Page</label>
                <select name="per_page" id="per_page" class="form-select">
                    <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $perPage == 20 ? 'selected' : '' ?>>20</option>
                    <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= $perPage == 100 ? 'selected' : '' ?>>100</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="text-muted">
                Total Records: <?= $pager->getTotal() ?>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tracking Records</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Source</th>
                            <th>Medium</th>
                            <th>UTM Campaign</th>
                            <th>Landing Page</th>
                            <th>Device</th>
                            <th>Browser</th>
                            <th>First Visit</th>
                            <th>Converted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($trackingData)): ?>
                            <?php foreach ($trackingData as $tracking): ?>
                                <tr>
                                    <td><?= $tracking['id'] ?></td>
                                    <td>
                                        <?php if ($tracking['user_id']): ?>
                                            User #<?= $tracking['user_id'] ?>
                                        <?php else: ?>
                                            Guest
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $tracking['source'] ?></td>
                                    <td><?= $tracking['medium'] ?></td>
                                    <td><?= $tracking['utm_campaign'] ?: '-' ?></td>
                                    <td>
                                        <a href="<?= $tracking['landing_page'] ?>" target="_blank" title="<?= $tracking['landing_page'] ?>">
                                            <?= substr($tracking['landing_page'], 0, 50) ?>...
                                        </a>
                                    </td>
                                    <td><?= $tracking['device'] ?></td>
                                    <td><?= $tracking['browser'] ?></td>
                                    <td><?= date('M j, Y H:i', strtotime($tracking['first_visit_time'])) ?></td>
                                    <td>
                                        <?php if ($tracking['is_converted']): ?>
                                            <span class="badge badge-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">No</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">No tracking data found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($pager->getPageCount() > 1): ?>
                <div class="mt-4">
                    <?= $pager->links('default', 'custom_pagination') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const perPageSelect = document.getElementById('per_page');
    
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const perPage = this.value;
            const currentUrl = new URL(window.location.href);
            
            // Update or add the per_page parameter
            currentUrl.searchParams.set('per_page', perPage);
            
            // Redirect to the new URL
            window.location.href = currentUrl.toString();
        });
    }
});
</script>
<?= $this->endSection() ?>