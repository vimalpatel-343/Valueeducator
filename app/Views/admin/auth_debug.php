<?= $this->include('admin/header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Authentication Debug Dashboard</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" onclick="location.reload()">
                            <i class="fas fa-sync"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- System Health -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>System Information</h5>
                            <div class="row">
                                <?php foreach ($systemInfo as $key => $value): ?>
                                <div class="col-md-3">
                                    <small class="text-muted"><?= ucfirst(str_replace('_', ' ', $key)) ?></small>
                                    <div><strong><?= $value ?></strong></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Errors -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Recent Errors</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Message</th>
                                            <th>Context</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentErrors as $error): ?>
                                        <tr>
                                            <td><?= $error['timestamp'] ?></td>
                                            <td><?= $error['message'] ?></td>
                                            <td>
                                                <?php if (!empty($error['context'])): ?>
                                                    <pre><?= json_encode($error['context'], JSON_PRETTY_PRINT) ?></pre>
                                                <?php endif; ?>
                                                <?php if (!empty($error['exception'])): ?>
                                                    <small class="text-danger">
                                                        <?= $error['exception']['message'] ?> in <?= $error['exception']['file'] ?>:<?= $error['exception']['line'] ?>
                                                    </small>
                                                <?php endif; ?>
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
    </div>
</div>

<?= $this->include('admin/footer') ?>