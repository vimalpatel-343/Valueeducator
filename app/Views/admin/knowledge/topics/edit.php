<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Knowledge Centre / Topics /</span> Edit Topic</h4>
    
    <!-- Alerts -->
    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php foreach (session('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Edit Topic Form -->
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Topic Information</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/knowledge-centre/update-topic/'.$topic['id']) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sector_id" class="form-label">Sector</label>
                            <select class="form-select" id="sector_id" name="sector_id" required>
                                <option value="">Select Sector</option>
                                <?php foreach ($sectors as $sector): ?>
                                    <option value="<?= $sector['id'] ?>" <?= old('sector_id', $topic['sector_id']) == $sector['id'] ? 'selected' : '' ?>>
                                        <?= $sector['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Topic Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $topic['name']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                            <div class="form-text">Upload topic icon (JPG, PNG, GIF)</div>
                            <?php if (!empty($topic['icon'])): ?>
                                <div class="mt-2">
                                    <img src="<?= base_url($topic['icon']) ?>" alt="Current Icon" width="60" height="60">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', $topic['sort_order']) ?>" required>
                            <div class="form-text">Lower numbers appear first</div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="6" required><?= old('description', $topic['description']) ?></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" <?= old('active', $topic['active']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">Update Topic</button>
                        <a href="<?= base_url('admin/knowledge-centre/topics') ?>" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
 $(document).ready(function() {
    loadEditor('#description');
});
</script>
<?= $this->endSection() ?>