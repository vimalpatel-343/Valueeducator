<?= $this->include('front/header') ?>

<div class="sc-testimonial-section-three pt-5 sc-pb-60 sc-md-pb-60 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-15 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h3 class="font-lg-24-bold">Quarterly Model Portfolio Updates - Emerging Titans</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="" id="blog-container">
            <div class="row">
                <?php if (empty($quarterlyUpdates)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <p class="mb-0">No quarterly updates available at the moment. Please check back later.</p>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($quarterlyUpdates as $item): ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="sidebar-popular-post m-height-295 sc-mb-10" style="background:#F7F7F7;">
                            <div class="sidebar-title sc-mb-10">
                                <h3 class="font-lg-20-bold font-20-bold sc-mb-0"><?= $item['fld_title'] ?></h3>
                                <p class="subheading"><?= $item['fld_subtitle'] ?? 'Model Portfolio Update' ?></p>
                            </div>
                            <div class="sc-mb-0">
                                <div class="video-container">
                                    <iframe src="<?= $item['fld_video_url'] ?>" 
                                            width="340" 
                                            height="376" 
                                            frameborder="0" 
                                            allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" 
                                            title="<?= $item['fld_title'] ?>">
                                    </iframe>
                                </div>
                                <p class="subheading" style="margin-top:1rem; margin-bottom:0rem;">
                                    Last updated on: <?= date('d/m/Y', strtotime($item['fld_updated_at'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->include('front/footer') ?>