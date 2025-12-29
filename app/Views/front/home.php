<?= $this->include('front/header') ?>

<!-- Statistics Section -->
<section class="sc-statistics-section-area sc-pb-50 sc-md-pb-0">
    <div class="container">
        <div class="sc-statistics-style">
            <div class="row">
                <div class="col-lg-7">
                    <div class="sc-statistics-left-content">
                        <div class="sc-ab-image" data-sal="slide-up" data-sal-duration="800" data-sal-delay="250">
                            <img class="sc-border-radius" src="<?= base_url('images/home/img-home.svg') ?>" alt="Value Educator" />
                        </div>
                        <div class="sc-heading-area sc-mb-35">
                            <h2 class="text-md-start text-center sc-mt-20 font-lg-40-bold font-24-bold">
                                Empowering You to Invest Early in Growth that Lasts
                            </h2>
                            <h3 class="text-md-start text-center font-lg-28-bold sc-mt-20 font-20-normal">Your Partner for Multibagger Stock Opportunities</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 sc-statistics-area sc-pl-70 sc-md-pl-0 sc-md-mt-0">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <div class="sc-statistics-service-box h-400 h-md-400 sc-mb-25 text-left" data-sal="slide-up" data-sal-duration="200" data-sal-delay="200">
                                <div class="sc-counter-number">
                                    <?php 
                                        $value = preg_replace('/[^0-9]/', '', $statistics['hidden_gems']['value']);
                                        $suffix = str_replace($value, '', $statistics['hidden_gems']['value']);
                                    ?>
                                    <div class="sc-count">
                                        <span class="odometer font-lg-40-bold font-32-bold letter-space-1" data-count="<?= $value ?>"><?= $statistics['hidden_gems']['value'] ?></span>
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal"><?= $statistics['hidden_gems']['label'] ?></span>
                                </div>
                            </div>
                            
                            <div class="sc-statistics-service-box h-200 h-md-200 sc-mb-25 text-left" data-sal="slide-up" data-sal-duration="300" data-sal-delay="300">
                                <div class="sc-counter-number">
                                    <?php 
                                        $value = preg_replace('/[^0-9]/', '', $statistics['youtube_subscribers']['value']);
                                        $suffix = str_replace($value, '', $statistics['youtube_subscribers']['value']);
                                    ?>
                                    <div class="sc-count">
                                        <span class="odometer font-lg-40-bold font-32-bold letter-space-1" data-count="<?= $value ?>"><?= $statistics['youtube_subscribers']['value'] ?></span>
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal"><?= $statistics['youtube_subscribers']['label'] ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-6">
                            <div class="sc-statistics-service-box h-200 h-md-200 sc-mb-25 text-left" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                                <div class="sc-counter-number">
                                    <?php 
                                        $value = preg_replace('/[^0-9]/', '', $statistics['investors_empowered']['value']);
                                        $suffix = str_replace($value, '', $statistics['investors_empowered']['value']);
                                    ?>
                                    <div class="sc-count">
                                        <span class="odometer font-lg-40-bold font-32-bold letter-space-1" data-count="<?= $value ?>"><?= $statistics['investors_empowered']['value'] ?></span>
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal"><?= $statistics['investors_empowered']['label'] ?></span>
                                </div>
                            </div>
                            
                            <div class="sc-statistics-service-box h-400 h-md-400 sc-mb-25 text-left" data-sal="slide-up" data-sal-duration="500" data-sal-delay="500">
                                <div class="sc-counter-number">
                                    <?php 
                                        $value = preg_replace('/[^0-9]/', '', $statistics['years_experience']['value']);
                                        $suffix = str_replace($value, '', $statistics['years_experience']['value']);
                                    ?>
                                    <div class="sc-count">
                                        <span class="odometer font-lg-40-bold font-32-bold letter-space-1" data-count="<?= $value ?>"><?= $statistics['years_experience']['value'] ?></span>
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal"><?= $statistics['years_experience']['label'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Investment Philosophy Section -->
<div class="sc-team-section-area sc-pb-50 sc-md-pb-50 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mt-0 sc-mb-20 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mt-0 sc-md-mt-0 sc-mb-10 sc-md-mb-10">
                        <h3 class="text-lg-start text-center mx-lg-0 mx-auto font-lg-32-bold font-20-bold">Our Investment Philosophy</h3>
                        <a href="<?= base_url('investment-philosophy') ?>" aria-label="Learn more about our investment philosophy" class="more d-none d-md-inline-block">Learn More</a>
                    </div>
                    <span class="sub-title d-none d-md-block font-lg-16-normal">
                        <span>SPRINT</span> represents a dynamic investment approach, centered on uncovering businesses with the potential for rapid and sustainable profitability...
                    </span>
                </div>
            </div>
        </div>
        
        <div class="swiper sc-pagination-active sc-swiper-slider">
            <div class="swiper-wrapper">
                <?php foreach ($philosophies as $philosophy): ?>
                <div class="swiper-slide">
                    <div class="sc-team-item text-left">
                        <div class="item-img">
                            <div class="team-image">
                                <a href="#">
                                    <img src="<?= base_url('images/investment_philosophy/' . $philosophy['fld_image']) ?>" alt="<?= $philosophy['fld_title'] ?>" />
                                </a>
                            </div>
                            <div class="sc-team-content">
                                <h1 class="letter"><?= substr($philosophy['fld_title'], 0, 1) ?></h1>
                                <h3 class="font-lg-24-bold font-20-bold"><?= $philosophy['fld_title'] ?></h3>
                                <span class="font-lg-16-normal"><?= $philosophy['fld_description'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
            <a class="sc-primary-btn d-block d-md-none text-center btn-color-white font-18-medium" href="<?= base_url('investment-philosophy') ?>" aria-label="Learn more about our investment philosophy">Learn More</a>
        </div>
    </div>
</div>

<!-- Product Offerings Section -->
<div class="sc-service-section-three light-purple-color sc-pt-50 sc-md-pt-50 sc-pb-50 sc-md-pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-35 text-lg-center text-start">
                    <h2 class="title font-lg-32-bold">Our Product Offerings</h2>
                </div>
            </div>
        </div>
        
        <div class="row d-none d-md-flex">
            <?php foreach ($products as $productData): ?>
            <div class="col-lg-6 col-md-12">
                <div class="titan-box sticky-heading">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="text-lg-start text-center font-lg-24-bold font-20-bold sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0">
                            <?= $productData['product']['fld_title'] ?>
                        </h3>
                        <p class="more d-none font-lg-20-normal d-md-inline-block sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0">
                            Rs. <?= number_format($productData['product']['fld_pricing'], 2) ?>/year
                        </p>
                    </div>
                </div>
                
                <div class="scroll-section">
                    <div class="titan-box hgt-200" style="display: flex; align-items: center; justify-content: center;">
                        <p class="font-lg-16-normal"><?= $productData['product']['fld_description'] ?></p>
                    </div>
                    
                    <div class="titan-box">
                        <iframe src="<?= $productData['product']['fld_video_url'] ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" width="100%" height="350"></iframe>
                    </div>
                    
                    <div class="titan-box hgt-900" style="display: flex; align-items: center; justify-content: center;">
                        <div class="row sc-md-mt-30">
                            <?php foreach ($productData['features'] as $feature): ?>
                            <div class="col-lg-6 col-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
                                <div class="sc-services-style3 min-hgt-200">
                                    <div class="sc-service-text text-center">
                                        <div class="sc-services-icon">
                                            <img src="<?= base_url('product_images/' . $feature['fld_image']) ?>" class="set-w" alt="<?= $feature['fld_title'] ?>">
                                        </div>
                                        <h4 class="service-title font-lg-24-semibold font-20-bold"><?= $feature['fld_title'] ?></h4>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="titan-box text-center">
                        <img src="<?= base_url('product_images/' . $productData['product']['fld_image']) ?>" width="240" alt="<?= $productData['product']['fld_title'] ?>" />
                    </div>
                    
                    <div class="titan-box">
                        <div class="text-center">
                            <img src="<?= base_url('images/product/empowering-01.svg') ?>" alt="<?= $productData['product']['fld_title'] ?>">
                            <h3 class="sc-mb-0 font-lg-36-bold font-36-bold text-md-center text-start">
                                ₹<?= number_format($productData['product']['fld_pricing'], 2) ?>
                            </h3>
                            <p class="font-lg-18-normal font-18-medium text-md-center text-start">(12 month subscription)</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <a class="w-100 sc-primary-btn btn-color-1 text-center" href="<?= base_url($productData['product']['fld_slug']) ?>" aria-label="Learn more about <?= $productData['product']['fld_title'] ?> stocks">Learn More</a>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <a class="w-100 sc-primary-btn btn-color-3 text-center buy-now-btn" href="#" 
                               data-product-name="<?= $productData['product']['fld_title'] ?>" 
                               data-amount="<?= $productData['product']['fld_pricing'] ?>" 
                               data-sub-title="12 month subscription" 
                               data-expired-month="12">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Mobile Tabs for Products -->
        <ul class="nav nav-pills titan-tabs d-flex d-md-none justify-content-center mb-3" id="titansTab" role="tablist">
            <?php foreach ($products as $index => $productData): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $index == 0 ? 'active' : '' ?>" 
                        id="tab-<?= $index+1 ?>" 
                        data-bs-toggle="pill" 
                        data-bs-target="#tab-pane-<?= $index+1 ?>" 
                        type="button" 
                        role="tab">
                    <?= $productData['product']['fld_title'] ?>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
        
        <div class="tab-content d-block d-md-none">
            <?php foreach ($products as $index => $productData): ?>
            <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>" 
                 id="tab-pane-<?= $index+1 ?>" 
                 role="tabpanel">
                <!-- Mobile product content similar to desktop but simplified -->
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- YouTube Videos Section -->
<div class="sc-team-section-area sc-pb-30 sc-md-pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-md-mt-40 sc-mb-10 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mb-10 sc-md-mb-10">
                        <h3 class="font-lg-32-bold">Youtube Videos</h3>
                        <a href="https://youtube.com/@valueeducator?si=AcHPU4YALAFmfT7e" class="more font-lg-16-bold">See All</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="swiper sc-pagination-active-30 sc-blog-slider">
            <div class="swiper-wrapper">
                <?php foreach ($youtubeVideos as $video): ?>
                <div class="swiper-slide">
                    <div class="sc-test-item">
                        <div class="video-container" data-index="<?= $video['id'] ?>">
                            <iframe width="560" height="315"
                                src="<?= str_replace('youtube.com', 'youtube-nocookie.com', $video['video_url']) ?>"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen>
                            </iframe>
                        </div>
                        
                        <div class="sc-auother-text d-flex align-items-center">
                            <div class="sc-auother-header sc-mt-20">
                                <div class="min-hgt-70">
                                    <h4 class="font-lg-20-bold"><?= $video['title'] ?></h4>
                                    <p class="font-lg-16-normal"><?= $video['description'] ?></p>
                                </div>
                                <p class="views font-lg-16-normal">
                                    <?= $video['views'] ?> views &bull; 
                                    Posted <?= $video['posted_at'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<?= $this->include('front/footer') ?>