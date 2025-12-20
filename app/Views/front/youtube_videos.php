<?= $this->include('front/header') ?>

<div class="sc-team-section-area pt-4 sc-pb-30 sc-md-pb-30 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-15 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h3 class="font-lg-24-bold">YouTube Videos</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog-metro-layout-wrapper">
            <div class="row">
                <?php if (empty($youtubeVideos)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <p class="mb-0">No YouTube videos available at the moment. Please check back later.</p>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($youtubeVideos as $index => $video): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-grid-overlay-blog-post sc-pb-20">
                            <div class="single-grid-overlay-blog-post__image">
                                <div class="video-container" data-index="<?= $index + 1 ?>">
                                    <iframe src="https://www.youtube.com/embed/<?= $video['video_id'] ?>" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                    </iframe>
                                </div>  
                            </div>									
                            <div class="single-grid-overlay-blog-post__content">                                        
                                <h3 class="post-title font-lg-16-bold sc-pt-10 sc-pb-0 sc-md-pb-0"><?= $video['fld_title'] ?></h3>
                                <p class="font-lg-14-normal"><?= short_text($video['fld_description'], 50) ?></p>
                                <span class="post-date font-lg-16-normal font-dark-grey">
                                    <?= shortNumber($video['fld_total_views']) ?> views • Posted <?= time_ago(strtotime($video['time_elapsed'])) ?>
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