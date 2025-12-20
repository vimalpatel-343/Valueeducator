<?= $this->include('front/header') ?>

<div class="sc-team-section-area pt-4 sc-pb-30 sc-md-pb-30 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-15 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h1 class="font-lg-24-bold"><?= $category['fld_title'] ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog-metro-layout-wrapper">
            <div class="row">
                <?php if (empty($items)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <p class="mb-0">No resources available in this category yet. Please check back later.</p>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($items as $index => $item): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-grid-overlay-blog-post sc-pb-20">
                            <div class="single-grid-overlay-blog-post__image">
                                <div class="video-container" data-index="<?= $index + 1 ?>">
                                    <iframe src="<?= $item['fld_video_url'] ?>" 
                                            frameborder="0" 
                                            allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" 
                                            title="<?= $item['fld_title'] ?>" 
                                            allowfullscreen>
                                    </iframe>
                                </div> 
                            </div>								
                            <div class="single-grid-overlay-blog-post__content">                                        
                                <h2 class="post-title font-lg-16-bold sc-pt-10 sc-pb-0 sc-md-pb-0"><?= $item['fld_title'] ?></h2>
                                <p class="font-lg-14-normal"><?= $item['fld_description'] ?></p>
                                <span class="post-date font-lg-16-normal font-dark-grey">
                                    <span id="duration-<?= $index + 1 ?>"><?= $item['fld_duration'] ?></span> 
                                    &nbsp; • &nbsp; 
                                    Posted <?= date('F j, Y', strtotime($item['fld_posted_at'])) ?>
                                </span>
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