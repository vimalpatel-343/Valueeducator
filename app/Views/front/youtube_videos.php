<?= $this->include('front/header') ?>

<div class="sc-team-section-area pt-4 sc-pb-30 sc-md-pb-30 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-15 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h3 class="font-lg-24-bold">YouTube Videos</h3>
                        <p class="text-muted">Showing <?= (($currentPage - 1) * $perPage) + 1 ?> to <?= min($currentPage * $perPage, $totalVideos) ?> of <?= $totalVideos ?> videos</p>
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
                                <div class="video-container">
                                    <lite-youtube videoid="<?= esc($video['fld_video_id']) ?>"></lite-youtube>
                                </div>  
                            </div>									
                            <div class="single-grid-overlay-blog-post__content">                                        
                                <h3 class="post-title font-lg-16-bold sc-pt-10 sc-pb-0 sc-md-pb-0"><?= $video['fld_title'] ?></h3>
                                <p class="font-lg-14-normal"><?= short_text_char($video['fld_description'], 200) ?></p>
                                <span class="post-date font-lg-16-normal font-dark-grey">
                                    <?= shortNumber($video['fld_total_views']) ?> views • Posted <?= time_ago(strtotime($video['fld_posted_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>                  
            
            <!-- Pagination -->
            <?php if (isset($pagination) && $totalVideos > $perPage): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <nav aria-label="YouTube videos pagination">
                            <ul class="pagination">
                                <?= $pagination ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Lite YouTube JavaScript -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lite-youtube-embed@0.3.2/src/lite-yt-embed.css" />
<script src="https://cdn.jsdelivr.net/npm/lite-youtube-embed@0.3.2/src/lite-yt-embed.js"></script>

<style>
    .video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        max-height: 300px;
    }

    .video-container lite-youtube {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .pagination li.active {
        background-color: #696cff !important;
        color: #FFFFFF;
    }
    .pagination li {
        background-color: #cccccc;
        border-radius: 5px;
        padding: 5px 15px;
        margin-right: 5px;
    }

    .pagination ul li a {
        line-height: 30px;
        color: #121212;
        margin: 0;
    }

    .pagination ul li.active a {
        color: #FFFFFF;
    }
</style>
<?= $this->include('front/footer') ?>