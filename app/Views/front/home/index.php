<?= $this->include('front/header') ?>

<style>
.hidden-content {
    width:270px;
    padding: 12px 18px 0px;
} 
.titan-box {
    background:#F9F6FF;
    padding:16px 16px;
    margin:20px 0px;
    border-radius:16px;
}
.titan-box.hgt-200 {
    height:200px;
}
.titan-box.hgt-900 {
    height:900px;
}
.sticky-heading {
  flex: 0 0 auto; 
  position: sticky;
  top: 0px;   
  z-index: 1;
  background: #F9F6FF; 
  box-shadow:0px 0px 15px #ccc;
  margin-bottom:12px;
}
.scroll-section {
  flex: 1 1 auto;
  overflow-y: auto;
  overflow-x: hidden;
  padding-right: 0px;
}
.titan-tabs {
  display: flex;
  justify-content: center!important;
  width:100%!important;
  background:#fff;
  border-radius: 20px;
}
.titan-tabs .nav-item {
  flex: 1!important;
  text-align: center;
}
.titan-tabs .nav-link {
  display: block;
  border-radius: 20px;
  margin: 0 0px;
  padding: 10px 0;
  font-weight: 600;
  background: #fff;
  font-size:16px;
  color: #333;
  border: 0px solid #ddd;
  width:100%!important;  
}
.titan-tabs .nav-link.active {
  background: #9155F1;
  color: #fff;
  border-color: #9155F1;
}
.font-18-semibold {
    font-size:18px!important;
    font-weight:600!important;
    line-height:20px!important;
}
.font-lg-24-semibold {
    font-size:24px!important;
    font-weight:600!important;
}
@media (max-width: 768px) {
.titan-tabs {
    position: sticky;
    top: 0;
    z-index: 15;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    padding: 8px 0;
  }
  .swiper-button-next {
    right:0px !important;
	left:inherit;
    opacity: 1 !important;
    visibility: visible !important;
	
  }
  .swiper-button-prev {
    left: 10px !important;
    opacity: 1 !important;
    visibility: visible !important;
  }
}
</style>

<!-- Hero Section with Statistics -->
<section class="sc-statistics-section-area sc-pb-50 sc-md-pb-0">
    <div class="container">
        <div class="sc-statistics-style">
            <div class="row">
                <div class="col-lg-7">
                    <div class="sc-statistics-left-content">
                        <div class="sc-ab-image sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="250">
                            <?php 
                            $homeMainImage = isset($pageImages['home']['main_image']) ? $pageImages['home']['main_image'] : null;
                            if ($homeMainImage): ?>
                                <img class="sc-border-radius" src="<?= base_url($homeMainImage['image_path']) ?>" alt="<?= $homeMainImage['image_alt'] ?>">
                            <?php else: ?>
                                <img class="sc-border-radius" src="images/home/img-home.svg" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="sc-heading-area sc-mb-35">
                            <h1 class="text-md-start text-center sc-mt-20 font-lg-40-bold font-24-bold">
                                Empowering You to Invest Early in Growth that Lasts
                            </h1>
                            <h2 class="text-md-start text-center font-lg-28-bold sc-mt-20 font-20-normal">Your Partner for Multibagger Stock Opportunities</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 sc-statistics-area sc-pl-70 sc-md-pl-0 sc-md-mt-0">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <div class="sc-statistics-service-box h-400 h-md-400 sc-mb-25 text-left sal-animate" data-sal="slide-up" data-sal-duration="200" data-sal-delay="200">
                                <div class="sc-counter-number">
                                    <div class="sc-count">
                                        <span class="font-lg-40-bold font-32-bold letter-space-1 odometer odometer-auto-theme" data-count="<?= !empty($siteSettings['fld_hidden_gems']) ? $siteSettings['fld_hidden_gems'] : '50' ?>">
                                            <?= !empty($siteSettings['fld_hidden_gems']) ? $siteSettings['fld_hidden_gems'] : '50' ?>
                                        </span>+
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal">Hidden Gems Discovered</span>
                                </div>
                            </div>
                            <div class="sc-statistics-service-box h-200 h-md-200 sc-mb-25 text-left sal-animate" data-sal="slide-up" data-sal-duration="300" data-sal-delay="300">
                                <div class="sc-counter-number">
                                    <div class="sc-count">
                                        <?php 
                                            $youTubeSuscriber = '143';
                                            if (!empty($siteSettings['fld_youtube_subscribers'])) {
                                                if ($siteSettings['fld_youtube_subscribers'] >= 1000) {
                                                    $youTubeSuscriber = ($siteSettings['fld_youtube_subscribers'] / 1000);
                                                } else {
                                                    $youTubeSuscriber = $siteSettings['fld_youtube_subscribers'];
                                                }
                                            }
                                        ?>
                                        <span class="font-lg-40-bold font-32-bold letter-space-1 odometer odometer-auto-theme" data-count="<?= $youTubeSuscriber ?>">
                                            <?= $youTubeSuscriber ?>
                                        </span>K
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal">Youtube subscribers</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="sc-statistics-service-box h-200 h-md-200 sc-mb-25 text-left sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                                <div class="sc-counter-number">
                                    <div class="sc-count">
                                        <span class="font-lg-40-bold font-32-bold letter-space-1 odometer odometer-auto-theme" data-count="<?= !empty($siteSettings['fld_investors_empowered']) ? $siteSettings['fld_investors_empowered'] : '2000' ?>">
                                            <?= !empty($siteSettings['fld_investors_empowered']) ? $siteSettings['fld_investors_empowered'] : '2000' ?>
                                        </span>+
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal">Investors Empowered</span>
                                </div>
                            </div>
                            <div class="sc-statistics-service-box h-400 h-md-400 sc-mb-25 text-left sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="500">
                                <div class="sc-counter-number">
                                    <div class="sc-count">
                                        <span class="font-lg-40-bold font-32-bold letter-space-1 odometer odometer-auto-theme" data-count="<?= !empty($siteSettings['fld_years_experience']) ? $siteSettings['fld_years_experience'] : '60' ?>">
                                            <?= !empty($siteSettings['fld_years_experience']) ? $siteSettings['fld_years_experience'] : '60' ?>
                                        </span>+
                                    </div>
                                    <span class="sc-title p-z-idex position-relative font-lg-20-normal font-16-normal">Years of Combined Experience</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Offer Strip -->
<div class="offer-strip sc-pt-0 sc-md-pt-20 sc-mb-20 sc-md-mb-0" style="background: rgb(240, 255, 223); padding: 30px 0px 20px; border: none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="offer-strip d-lg-flex justify-content-between align-items-center" style="background:#F0FFDF; border-radius:8px; padding:20px;border: none;">
                    <div class="left-content d-lg-flex d-inline-block">
                        <?php 
                        $homeSubstackImage = isset($pageImages['home']['join_substack']) ? $pageImages['home']['join_substack'] : null;
                        if ($homeSubstackImage): ?>
                            <img src="<?= base_url($homeSubstackImage['image_path']) ?>" alt="<?= $homeSubstackImage['image_alt'] ?>" class="d-none d-md-block" style="text-align:center; margin:0px auto;">
                        <?php else: ?>
                            <img src="images/home/img-substack.svg" class="d-none d-md-block" style="text-align:center; margin:0px auto;">
                        <?php endif; ?>
                        <h2 class="d-none d-md-block title-24 sc-lg-ml-26 font-lg-24-bold">
                            Stay ahead in small &amp; mid-cap investing.						
                            <p class="font-lg-16-normal">Join our Substack for exclusive research, insights,<br> and updates delivered straight to you.</p>
                        </h2>
                        <?php 
                        $homeSubstackImage = isset($pageImages['home']['join_substack']) ? $pageImages['home']['join_substack'] : null;
                        if ($homeSubstackImage): ?>
                            <img src="<?= base_url($homeSubstackImage['image_path']) ?>" alt="<?= $homeSubstackImage['image_alt'] ?>" class="d-block d-md-none" style="text-align:center; margin:0px auto;">
                        <?php else: ?>
                            <img src="images/home/img-substack.svg" class="d-block d-md-none" style="text-align:center; margin:0px auto;">
                        <?php endif; ?>
                        <h2 class="d-block d-md-none text-center font-20-bold sc-pb-0 sc-md-pb-20">
                            Join our Substack
                            <span class="txt2 font-16-normal">Stay ahead with actionable insights and expert analysis to elevate your investment expertise.</span>
                        </h2>
                    </div>
                    <a class="sc-primary-btn btn-color-5 font-lg-20-normal" href="https://www.substack.com/@valueeducator" target="_blank">Register to Access</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Our Investment Philosophy -->
<div class="sc-team-section-area sc-pt-50 sc-md-pt-50 sc-pb-50 sc-md-pb-50 sc-md-mt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mt-0 sc-mb-20 text-left">
                    <div class="d-flex justify-content-between align-items-center sc-mt-0 sc-md-mt-0 sc-mb-10 sc-md-mb-10">
                        <h3 class="text-lg-start text-center mx-lg-0 mx-auto font-lg-32-bold font-20-bold sc-mt-0 sc-mb-0">Our Investment Philosophy</h3>
                        <a href="<?= base_url('investment-philosophy') ?>" class="more d-none d-md-inline-block" target="_blank">Learn More <span class="visually-hidden">about our investment philosophy</span></a>
                    </div>
                    <span class="sub-title d-none d-md-block font-lg-16-normal sc-mt-20"><span>SPRINT</span> represents a dynamic investment approach, centered on uncovering businesses with the potential for rapid and sustainable profitability, driven by scuttlebutt research at its core, and focused on seizing opportunities early to drive long-term wealth creation.</span>
                </div>
            </div>
        </div>
        <div class="swiper sc-pagination-active sc-swiper-slider sc-mt-20">
            <div class="swiper-wrapper">
                <?php if (!empty($philosophies)): ?>
                    <?php foreach ($philosophies as $philosophy): ?>
                        <div class="swiper-slide">
                            <div class="sc-team-item text-left">
                                <div class="item-img">
                                    <div class="team-image">
                                        <a href="#">
                                            <?php if (!empty($philosophy['fld_image'])): ?>
                                                <img src="<?= base_url($philosophy['fld_image']) ?>" alt="<?= esc($philosophy['fld_title']) ?>">
                                            <?php else: ?>
                                                <img src="images/home/img-philosophy-default.svg" alt="<?= esc($philosophy['fld_title']) ?>">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="sc-team-content">
                                        <h2 class="letter"><?= substr($philosophy['fld_title'], 0, 1) ?></h2>
                                        <h3 class="font-lg-24-bold font-20-bold"><?= esc($philosophy['fld_title']) ?></h3>
                                        <span class="font-lg-16-normal"><?= $philosophy['fld_description'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
        <a class="sc-primary-btn d-block d-md-none text-center btn-color-white- font-18-medium sc-mt-30" href="investment-philosophy">Learn More <span class="visually-hidden">about our investment philosophy</span></a>
    </div>
</div>

<!-- Our Product Offerings -->
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
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="titan-box sticky-heading">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-lg-start text-center font-lg-24-bold font-20-bold sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0"><?= esc($product['fld_title']) ?></h3>
                                <p class="more d-none font-lg-20-normal d-md-inline-block sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0">Rs. <?= number_format($product['fld_pricing'], 0) ?>/year</p>
                            </div>
                        </div>
                        <div class="scroll-section">
                            <div class="titan-box hgt-200" style="display: flex; align-items: center; justify-content: center;">
                                <p class="font-lg-16-normal"><?= esc($product['fld_research_framework']) ?></p>
                            </div>
                            <div class="titan-box">
                                <?php if (!empty($product['fld_video_url'])): ?>
                                    <iframe src="<?= esc($product['fld_video_url']) ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" title="<?= esc($product['fld_title']) ?>" width="100%" height="350"></iframe>
                                <?php endif; ?>
                            </div>
                            <div class="titan-box hgt-900" style="display: flex; align-items: center; justify-content: center;">
                                <div class="row sc-md-mt-30">
                                    <?php 
                                    // Get product features for this product
                                    if (isset($productFeatures[$product['id']]) && !empty($productFeatures[$product['id']])):
                                        foreach ($productFeatures[$product['id']] as $feature):
                                    ?>
                                        <div class="col-lg-6 col-6 sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
                                            <div class="sc-services-style3 min-hgt-200">
                                                <div class="sc-service-text text-center">
                                                    <div class="sc-services-icon">
                                                        <?php if (!empty($feature['fld_image'])): ?>
                                                            <img src="<?= base_url($feature['fld_image']) ?>" class="set-w" alt="<?= esc($feature['fld_title']) ?>" />
                                                        <?php else: ?>
                                                            <img src="images/product/default-feature-icon.svg" class="set-w" alt="<?= esc($feature['fld_title']) ?>" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <h4 class="service-title font-lg-24-semibold font-20-bold"><?= esc($feature['fld_title']) ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <div class="titan-box text-center">
                                <?php 
                                // Get app images for this product
                                if (isset($appImages[$product['id']]) && !empty($appImages[$product['id']]) && isset($appImages[$product['id']][0])):
                                ?>
                                    <img src="<?= base_url($appImages[$product['id']][0]['fld_image']) ?>" width="300" height="630" alt="<?= esc($product['fld_title']) ?>" />
                                <?php else: ?>
                                    <img src="<?= base_url('images/product/default-product-image.png') ?>" width="300" height="630" alt="<?= esc($product['fld_title']) ?>" />
                                <?php endif; ?>
                            </div>
                            <div class="titan-box">
                                <div class="text-center">
                                    <img src="<?= base_url('images/product/empowering-01.svg') ?>" alt="<?= esc($product['fld_title']) ?>" />
                                    <h3 class="sc-mb-0 font-lg-36-bold font-36-bold text-md-center text-start">₹<?= number_format($product['fld_pricing'], 0) ?></h3>
                                    <p class="font-lg-18-normal font-18-medium text-md-center text-start">(12 month subscription)</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <a class="w-100 sc-primary-btn btn-color-1 text-center" href="<?= base_url($product['fld_slug']) ?>">Learn More <span class="visually-hidden"> about <?= $product['fld_title'] ?> stocks</span></a>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <a class="w-100 sc-primary-btn btn-color-3 text-center buy-now-btn" href="#" data-product-id="<?= esc($product['id']) ?>" data-product-name="<?= esc($product['fld_title']) ?>" data-amount="<?= esc($product['fld_pricing']) ?>" data-sub-title="12 month subscription" data-expired-month="12">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Tabs for Mobile -->
        <ul class="nav nav-pills titan-tabs d-flex d-md-none justify-content-center mb-3" id="titansTab" role="tablist">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $index => $product): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $index == 0 ? 'active' : '' ?>" id="tab-<?= $index+1 ?>" data-bs-toggle="pill" data-bs-target="#tab-pane-<?= $index+1 ?>" type="button" role="tab">
                            <?= esc($product['fld_title']) ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content d-block d-md-none">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $index => $product): ?>
                    <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>" id="tab-pane-<?= $index+1 ?>" role="tabpanel">
                        <div class="col-lg-6 col-md-12">
                            <div class="titan-box">
                                <h3 class="text-start font-lg-24-bold font-24-bold"><?= esc($product['fld_title']) ?></h3>
                                <p class="font-lg-16-normal"><?= esc($product['fld_research_framework']) ?></p>
                                
                                <!-- Video -->
                                <?php if (!empty($product['fld_video_url'])): ?>
                                    <iframe src="<?= esc($product['fld_video_url']) ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" title="<?= esc($product['fld_title']) ?>" width="100%" height="350"></iframe>
                                <?php endif; ?>
                                
                                <!-- Features -->
                                <div class="row sc-md-mt-30">
                                    <?php 
                                    // Get product features for this product
                                    if (isset($productFeatures[$product['id']]) && !empty($productFeatures[$product['id']])):
                                        foreach ($productFeatures[$product['id']] as $feature):
                                    ?>
                                        <div class="col-lg-6 col-12">
                                            <div class="sc-services-style3">
                                                <div class="sc-service-text text-center">
                                                    <div class="sc-services-icon d-flex align-items-center">
                                                        <?php if (!empty($feature['fld_image'])): ?>
                                                            <img src="<?= base_url($feature['fld_image']) ?>" style="width:72px;">
                                                        <?php else: ?>
                                                            <img src="images/product/default-feature-icon.svg" style="width:72px;">
                                                        <?php endif; ?>
                                                        <h4 class="font-lg-20-bold font-18-semibold text-start">
                                                            <?= esc($feature['fld_title']) ?>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                            
                            <!-- Product Image -->
                            <div class="titan-box text-center">
                                <?php 
                                // Get app images for this product
                                if (isset($appImages[$product['id']]) && !empty($appImages[$product['id']]) && isset($appImages[$product['id']][0])):
                                ?>
                                    <img src="<?= base_url($appImages[$product['id']][0]['fld_image']) ?>" style="width:100%; height:auto; display:block;" alt="<?= esc($product['fld_title']) ?>">
                                <?php else: ?>
                                    <img src="images/product/default-product-image.png" style="width:100%; height:auto; display:block;" alt="<?= esc($product['fld_title']) ?>">
                                <?php endif; ?>
                            </div>
                            
                            <!-- Price -->
                            <div class="titan-box text-center">
                                <img src="<?= base_url('images/product/empowering-01.svg') ?>" alt="<?= esc($product['fld_title']) ?>" />
                                <h3 class="sc-mb-0 font-lg-36-bold font-36-bold">₹<?= number_format($product['fld_pricing'], 2) ?></h3>
                                <p class="font-lg-18-normal font-18-medium">(12 month subscription)</p>
                            </div>
                            
                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <a class="w-100 sc-primary-btn btn-color-1 text-center" href="<?= base_url($product['fld_slug']) ?>">Learn More <span class="visually-hidden"> about <?= $product['fld_title'] ?> stocks</span></a>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <a class="w-100 sc-primary-btn btn-color-3 text-center buy-now-btn" href="#" data-product-name="<?= esc($product['fld_title']) ?>" data-amount="<?= esc($product['fld_pricing']) ?>" data-sub-title="12 month subscription" data-expired-month="12">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class=" sc-pt-50 sc-md-pt-50 sc-mb-50 sc-md-mb-0">
    <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                <div class="offer-strip d-lg-flex justify-content-between align-items-center" style="background:#F7F7F7; border-radius:8px; padding:20px; border: none;">
                    <div class="left-content">
                        
                    <?php $shashankImageData = $pageImages['home']['shashank_image'] ?? null; ?>

                        <img src="<?= base_url($shashankImageData['image_path'] ?? 'images/shashank.jpeg') ?>" alt="<?= esc($shashankImageData['image_alt'] ?? 'Shashank') ?>" class="sc-md-mb-10 rounded-circle border" loading="lazy">

                        <h2 class="title-24 font-20-bold" style="line-height:26px; margin-left:26px;">
                        Value Educator							
                        <span class="txt2 font-lg-16-normal font-14-normal">@Value Educator • 143k subscribers</span></h2>
                        </div>
                        <a class="sc-primary-btn btn-color-5 font-lg-20-normal font-18-normal" href="https://www.youtube.com/@ValueEducator" target="_blank"><img src="images/notification.png" alt="Notification icon"> Subscribe to YouTube Channel</a>
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
                        <a href="https://youtube.com/@valueeducator?si=AcHPU4YALAFmfT7e" class="more font-lg-16-bold" target="_blank">See All</a>
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
                                    <iframe width="560" height="315" 
                                        src="https://www.youtube-nocookie.com/embed/<?= esc($video['video_id']) ?>" 
                                        title="<?= esc($video['fld_title']) ?>" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                        referrerpolicy="strict-origin-when-cross-origin" 
                                        allowfullscreen>
                                    </iframe>
    
                                </div>
                                <div class="sc-auother-text d-flex align-items-center">
                                    <div class="sc-auother-header sc-mt-20">
                                        <div class="min-hgt-70">
                                            <h4 class="font-lg-20-bold"><?= esc($video['fld_title']) ?></h4>
                                            <p class="font-lg-16-normal"><?= short_text_char(strip_tags($video['fld_description']), 100) ?></p>
                                        </div>
                                        <p class="views font-lg-16-normal"><?= shortNumber($video['fld_total_views']) ?> views • Posted <?= time_ago(strtotime($video['fld_posted_at'])) ?></p>
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

<div class="sc-service-section-two sc-pt-30 sc-md-pt-30 sc-pb-30 sc-md-pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6">
                <div class="sc-heading-area sc-mb-35 sc-md-pt-0 text-center d-block d-md-none">
                    <span class="sub-title sc-mb-0 font-16-normal"> Our Founder</span>
                    <h3 class="sc-mb-25 sc-mt-0 font-20-bold">Shashank Mahajan</h3>
                </div>
                <?php $homeFounderImage = $pageImages['home']['founder_image'] ?? null; ?>
                <img class="sc-border-radius" src="<?= base_url($homeFounderImage['image_path'] ?? 'images/home/founder.svg') ?>" alt="<?= esc($homeFounderImage['image_alt'] ?? '') ?>" loading="lazy">
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="sc-heading-area sc-mb-35 sc-md-pt-50 text-justify">
                <div class=" d-none d-md-block">
                    <span class="sub-title sc-mb-0 font-lg-16-normal" style="font-size:16px;"> Our Founder</span>

                    <h3 class="sc-mb-25 sc-mt-0 font-lg-24-bold">Shashank Mahajan</h3>
                    </div>
                    <p class="sc-mb-15 sc-mt-0 font-lg-20-bold font-16-bold">Driven by a passion for uncovering multibagger opportunities, our founder -an engineer and MBA- with 12+ years of experience founded the value educator to identify and unlock the high-growth potential of small and micro-cap stocks.</p>
                    <p class="sc-mb-25  sc-mt-0 font-lg-16-normal font-14-normal">Inspired by Warren Buffett’s value investing principles, his multibagger approach combines bottom-up stock picking, rigorous research, and a scuttlebutt to discover undervalued gems early. Through a thriving YouTube channel with over 143,000 subscribers, he shares actionable insights on stock analysis, business models, and market trends. With a steadfast focus on integrity and data-driven investing, he aims to empower investors to uncover hidden opportunities in the equity markets for sustainable wealth creation.</p>
                    <a class="sc-primary-btn d-block d-lg-inline-block text-center" href="<?= base_url('about-us') ?>" target="_blank">About Us</a>                    
                </div>
            </div>
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
        autoplay: false,
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

<link rel="stylesheet" href="<?= base_url('front/css/odometer-theme-default.css') ?>" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.8/odometer.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const counters = document.querySelectorAll(".odometer");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = el.getAttribute("data-count");

                el.innerHTML = 0; // start from zero
                setTimeout(() => {
                    el.innerHTML = target;
                }, 200);

                observer.unobserve(el); // animate only once
            }
        });
    }, {
        threshold: 0.6
    });

    counters.forEach(counter => {
        observer.observe(counter);
    });

});
</script>