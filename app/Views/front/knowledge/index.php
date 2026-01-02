<?= $this->include('front/header') ?>

<div class="sc-team-section-area sc-pb-40 sc-md-pb-40 sc-md-mt-0">
    <div class="container">

        <div class="row sc-pt-60 sc-md-pt-0">
            <?php foreach ($categories as $category): ?>
            <div class="col-lg-4 col-md-6 col-6 sc-pb-20">
                <?php if ($hasAccess): ?>
                    <a href="<?= base_url('knowledge-center/' . $category['fld_slug']) ?>" target="_blank">
                <?php else: ?>
                    <a href="#" class="disabled">
                <?php endif; ?>
                    <div class="sc-icon-box bdr p-xl-5 pb-3">
                        <?php if (!$hasAccess): ?>
                            <button class="paid-btn"><img src="images/lock.svg"> Paid Service</button>
                        <?php endif; ?>
                        <div class="sc-auother-header text-center">
                            <?php if (!empty($category['fld_image'])): ?>
                            <img src="<?= base_url($category['fld_image']) ?>" class="pt-2 pb-4"
                                alt="<?= $category['fld_title'] ?>">
                            <?php else: ?>
                            <img src="<?= base_url('front/images/default-category.svg') ?>" class="pt-2 pb-4"
                                alt="<?= $category['fld_title'] ?>">
                            <?php endif; ?>
                            <h5 class="font-lg-24-bold font-16-bold"><?= $category['fld_title'] ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class=" sc-pt-20 sc-md-pt-20 sc-mb-20 sc-md-mb-0 d-lg-block d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="offer-strip d-lg-flex justify-content-between align-items-center"
                    style="background:#F0FFDF; border-radius:8px; padding:30px 20px 20px;">
                    <div class="left-content d-lg-flex  d-inline-block">
                        <img src="images/download-ebook.svg" class="w-150">
                        <h2 class="title-24 sc-lg-ml-26 font-lg-32-bold font-20-bold">
                            Beyond the Radar
                            <span class="txt2 font-lg-18-normal font-16-normal" style="font-weight:600;">Mastering
                                Micro-Cap Investing</span>
                            <p class="font-lg-16-normal font-14-normal">Our tailor-made micro-cap investing handbook, <br/>exclusively designed for you.</p>
                        </h2>

                    </div>
                    <a class="sc-primary-btn btn-color-5 font-lg-20-normal font-18-medium"
                        href="<?= $siteSettings['fld_ebook'] ?>" target="_blank">Download free E-book</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sc-testimonial-section-three sc-pt-40 sc-pb-50 sc-md-pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-25 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h3 class="font-lg-32-bold">Substack</h3>
                        <a href="<?= base_url('substack-updates') ?>" class="more font-lg-16-bold">See All</a>
                    </div>
                    <span class="sub-title font-lg-16-normal">
                        Explore VE’s expert investment strategies, in-depth market insights,
                        and key learnings backed by years of experience - on our blog.
                    </span>
                </div>
            </div>
        </div>
        <!--row-->

        <div class="substack-container">
            
            <?php if (!empty($substackUpdates)): ?>
                <?php foreach ($substackUpdates as $update): ?>
                    <div class="substack-wrapper">
                        <div class="substack">
                            <a href="<?= $update['fld_url'] ?>" target="_blank">
                                <img src="<?= base_url($update['fld_image']) ?>" alt="<?= htmlspecialchars(strlen($update['fld_title']) > 30 ? substr($update['fld_title'], 0, 30) . '...' : $update['fld_title']) ?>">
                            </a>
                            <div class="substack-content">
                                <h3 class="font-lg-24-bold sc-mt-10"><?= htmlspecialchars(strlen($update['fld_title']) > 30 ? substr($update['fld_title'], 0, 30) . '...' : $update['fld_title']) ?></h3>
                                <p class="font-lg-16-normal"><?= character_limiter(strip_tags($update['fld_description']), 150) ?></p>
                            </div>
                            <div class="substack-footer">
                                <span class="arrow">
                                    <a href="<?= $update['fld_url'] ?>" target="_blank">
                                        <img src="images/blog.png" alt="Read More">
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="post-date">Posted 19 days ago</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No substack updates available</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class=" sc-pt-30 sc-md-pt-30 sc-mb-30 sc-md-mb-0">
    <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                <div class="offer-strip d-lg-flex justify-content-between align-items-center" style="background:#F7F7F7; border-radius:8px; padding:20px;">
                    <div class="left-content">
                    <img src="images/shashank.jpeg" class="sc-md-mb-10 rounded-circle" style="width:84px; height:84px;">
                
                        <h2 class="title-24 font-20-bold" style="line-height:26px; margin-left:26px;">
                        Value Educator							
                        <span class="txt2 font-lg-16-normal font-14-normal">@Value Educator • 143k subscribers</span></h2>
                        </div>
                        <a class="sc-primary-btn btn-color-5 font-lg-20-normal font-18-normal" href="<?= base_url('youtube-videos') ?>" target="_blank"><img src="images/notification.png" alt="Notification icon"> Subscribe to YouTube Channel</a>
                        </div>
                </div>
            </div>
    </div>
</div>

<!-- YouTube Video Section -->
<div class="sc-team-section-area sc-pb-30 sc-md-pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-md-mt-40 sc-mb-10 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h3 class="font-lg-32-bold">YouTube Videos</h3>
                        <a href="<?= base_url('youtube-videos') ?>" class="more font-lg-16-bold" target="_blank">See All</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="swiper sc-pagination-active-30 sc-blog-slider">
            <div class="swiper-wrapper">
                <?php if (!empty($videos)): ?>
                    <?php foreach ($videos as $video): ?>
                        <div class="swiper-slide">
                            <div class="sc-test-item">
                                <div class="video-container">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= esc($video['fld_video_id']) ?>" title="<?= esc($video['fld_title']) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                                </div>
                                <div class="sc-auother-text d-flex align-items-center">
                                    <div class="sc-auother-header sc-mt-20">
                                        <div class="min-hgt-70">
                                            <h5 class="font-lg-20-bold"><?= esc($video['fld_title']) ?></h5>
                                            <p class="font-lg-16-normal"><?= character_limiter(strip_tags($video['fld_description']), 100) ?></p>
                                        </div>
                                        <p class="views font-lg-16-normal"><?= $video['fld_total_views'] ?> views • Posted <?= time_ago(strtotime($video['fld_posted_at'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>


<script src="<?= base_url('front/js/swiper.min.js') ?>"></script>
<script>
    // Initialize Swiper for Investment Philosophy
    var philosophySwiper = new Swiper('.sc-swiper-slider', {
        slidesPerView: 3,
        spaceBetween: 25,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            }
        }
    });
    
    // Initialize Swiper for YouTube Videos
    var videoSwiper = new Swiper('.sc-blog-slider', {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            }
        }
    });
</script>

<?= $this->include('front/footer') ?>