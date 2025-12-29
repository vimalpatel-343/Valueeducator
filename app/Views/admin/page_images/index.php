<?= $this->extend('templates/base') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header border-1">
                    <h4 class="card-title mb-0">Page Images Management</h4>
                </div>
                <div class="card-body">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/page-images/update') ?>" method="post" enctype="multipart/form-data">
                        
                        <!-- Modern Tabs -->
                        <ul class="nav nav-pills shadow-sm rounded p-2" id="pageTabs" role="tablist">
                            <?php $active = 'active'; ?>
                            <?php foreach ($predefinedSections as $page => $sections): ?>
                                <li class="nav-item me-2" role="presentation">
                                    <button class="nav-link <?= $active ?> text-uppercase fw-bold-"
                                            id="<?= $page ?>-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#<?= $page ?>"
                                            type="button"
                                            role="tab"
                                            aria-controls="<?= $page ?>"
                                            aria-selected="<?= $active ? 'true' : 'false' ?>">
                                        <?= str_replace('_', ' ', ucfirst($page)) ?>
                                    </button>
                                </li>
                                <?php $active = ''; ?>
                            <?php endforeach; ?>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content p-0" id="pageTabsContent">
                            <?php $active = 'show active'; ?>
                            <?php foreach ($predefinedSections as $page => $sections): ?>
                                <div class="tab-pane fade <?= $active ?>" id="<?= $page ?>" role="tabpanel" aria-labelledby="<?= $page ?>-tab">
                                    <div class="row g-3 mt-2">
                                        <?php foreach ($sections as $section => $label): ?>
                                            <?php 
                                            $existingImage = isset($existingImages[$page][$section]) ? $existingImages[$page][$section] : null;
                                            ?>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="card h-100 border-0 shadow-sm hover-shadow">
                                                    <div class="card-header bg-light">
                                                        <h6 class="card-title mb-0"><?= $label ?></h6>
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <!-- Current Image -->
                                                        <div class="mb-3" style="min-height: 180px; ">
                                                            <?php if ($existingImage): ?>
                                                                <img src="<?= base_url($existingImage['image_path']) ?>" 
                                                                     alt="<?= $existingImage['image_alt'] ?>" 
                                                                     class="img-fluid rounded" 
                                                                     style="max-height: 180px; object-fit: cover;">
                                                            <?php else: ?>
                                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                                     style="height: 180px;">
                                                                    <span class="text-muted">No image uploaded</span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- File Upload -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Upload New Image</label>
                                                            <input type="file" 
                                                                   name="<?= $page ?>_<?= $section ?>" 
                                                                   class="form-control form-control-sm" 
                                                                   accept="image/*">
                                                            <small class="text-muted d-block mt-1">JPG, PNG, SVG, WEBP (Max 2MB)</small>
                                                        </div>

                                                        <!-- Alt Text -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Alt Text</label>
                                                            <input type="text" 
                                                                   name="alt_<?= $page ?>_<?= $section ?>" 
                                                                   class="form-control form-control-sm" 
                                                                   placeholder="Enter alternative text" 
                                                                   value="<?= $existingImage ? $existingImage['image_alt'] : '' ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php $active = ''; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Update Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i> Update All Images
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.15) !important;
    transition: all 0.3s ease-in-out;
}
</style>
<?= $this->endSection() ?>