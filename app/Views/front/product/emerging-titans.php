<?= $this->include('front/header') ?>

<section class="sc-statistics-section-area sc-pt-20 sc-md-pt-0 sc-pb-50 sc-md-pb-0">
    <div class="container">
        <div class="row d-lg-flex justify-content-between align-items-center">
            <div class="col-lg-7 sc-statistics-area sc-mt-0 sc-md-mt-0">
                <h1 class="text-start sc-mt-20 sc-md-mb-20 font-lg-32-bold font-24-bold">
                    <?= esc($product['fld_title']) ?>
                </h1>
                <p class="font-lg-20-normal font-14-normal sc-mt-20">
                    <?= $product['fld_description'] ?>
                </p>
                
                <div class="row sc-mt-30">	
                    <div class="col-md-12 col-12 sc-mb-10 d-flex justify-content-between align-items-center">
                        <h4 class="font-lg-24-bold font-20-bold sc-mb-0 sc-md-mb-0">In a nutshell</h4>
                        <div class="sc-primary-btn text-center font-lg-16-normal font-14-normal">
                            <img src="images/icon-speed.png"> High Volatility
                        </div>
                    </div>						
                    
                    <div class="col-md-6 col-6 sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                        <div class="sc-statistics-service-box h-md-400 sc-mb-25 text-center">
                            <img src="images/product/img-nutshell-1.svg" class="sc-pb-10 sc-md-pb-20">
                            <p class="sc-mb-0 sc-pb-0 sc-md-pb-10 font-lg-16-normal font-16-normal">Investment Horizon</p>
                            <h4 class="font-lg-20-bold font-20-bold"><?= esc($product['fld_holding_period']) ?></h4>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-6 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="500">
                        <div class="sc-statistics-service-box h-md-400 sc-mb-25 text-center">
                            <img src="images/product/img-nutshell-2.svg" class="sc-pb-10 sc-md-pb-20">
                            <p class="sc-mb-0 sc-pb-0 sc-md-pb-10 font-lg-16-normal font-16-normal">Minimum Investment</p>
                            <h4 class="font-lg-20-bold font-20-bold"><i class="fa fa-inr"></i>&nbsp;<?= number_format($product['fld_minimum_investment'],0) ?></h4>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-6 sal-animate" data-sal="slide-up" data-sal-duration="600" data-sal-delay="600">
                        <div class="sc-statistics-service-box h-md-400 sc-mb-25 text-center">
                            <img src="images/product/img-nutshell-3-new.svg" class="sc-pb-10 sc-md-pb-20">
                            <p class="sc-mb-0 sc-pb-0 sc-md-pb-10 font-lg-16-normal font-16-normal">Rebalance Frequency</p>
                            <h4 class="font-lg-20-bold font-20-bold"><?= esc($product['fld_rebalance_frequency']) ?></h4>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-6 sal-animate" data-sal="slide-up" data-sal-duration="700" data-sal-delay="700">
                        <div class="sc-statistics-service-box h-md-400 sc-mb-25 text-center">
                            <img src="images/product/img-nutshell-4.svg" class="sc-pb-10 sc-md-pb-20">
                            <p class="sc-mb-0 sc-pb-0 sc-md-pb-10 font-lg-16-normal font-16-normal">Next Rebalance</p>
                            <h4 class="font-lg-20-bold font-20-bold"><?= esc($product['fld_next_rebalance']) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 order-first order-md-0">
                <div class="sc-statistics-left-content">                               
                    <div class="sc-ab-image sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="250">
                        <img class="sc-border-radius" src="images/product/empowering-new.svg" alt="" style="margin:0px auto;">
                    </div>								
                </div>
            </div>
        </div>
    </div>
</section>

<div class="sc-team-section-area light-purple-color sc-pb-0 sc-md-pb-0 sc-mt-0 sc-md-mt-0">
    <div class="container">
        <div class="row sc-pt-50 sc-md-pt-40">
            <div class="col-lg-12 col-md-12 sc-pb-40 text-md-center text-start">
                <h4 class="title-24 sc-mb-20 sc-mt-0 font-lg-24-bold font-16-bold">Watch this video to learn more about <?= esc($product['fld_title']) ?></h4>							
            
                <?php if (!empty($product['fld_video_url'])): ?>
                    <iframe src="<?= esc($product['fld_video_url']) ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" title="<?= esc($product['fld_title']) ?>" width="100%" height="350"></iframe>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="sc-testimonial-section-three sc-pt-30 sc-pb-20">
    <div class="container my-4">
        <div class="row">
            <?php if (!empty($appImages)): ?>
                <?php 
                    // limit max 5 images
                    $images = array_slice($appImages, 0, 5); 
                    $col = 12 / count($images); // auto column width
                ?>
                
                <?php foreach ($images as $image): ?>
                    <div class="col-<?php echo $col; ?> text-center mb-3- p-5">
                        <img src="<?= base_url($image['fld_image']) ?>" class="img-fluid w-100" style="object-fit: cover;" alt="Product Image">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="sc-team-section-area sc-pb-40 sc-md-pb-20 sc-md-mt-0">
    <div class="container">
        <div class="row sc-pt-0 sc-md-pt-40">
            <div class="col-lg-12 col-md-12 d-none d-lg-block">
                <div class="sc-heading-area sc-mb-25 text-center">
                    <h3 class="font-lg-32-bold font-20-bold">Product Features</h3>
                </div>
            </div>
        </div>
        
        <div class="row">
            <?php if (!empty($features)): ?>
                <?php foreach ($features as $feature): ?>
                    <div class="col-lg-4 col-md-12 sc-pb-20">
                        <div class="sc-team-item no-pad text-center text-lg-start min-hgt-400">
                            <div class="item-img">
                                <div class="team-image text-center">
                                    <a href="#">
                                        <img src="<?= base_url($feature['fld_image']) ?>" class="no-hover" alt="">
                                    </a>
                                </div>
                                
                                <div class="sc-team-content sc-mt-15">
                                    <h4 class="font-lg-24-bold font-20-bold"><?= esc($feature['fld_title']) ?></h4>
                                    <span class="font-lg-16-normal font-14-normal" style="color:#121212;">
                                        <?= $feature['fld_description'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="sc-service-section-three sc-pt-30 sc-md-pt-0 sc-pb-30 sc-md-pb-30">
    <div class="container">
        <div class="row sc-pt-0 sc-md-pt-0">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-25 text-center d-none d-lg-block">
                    <h3 class="font-lg-32-bold">Pricing</h3>							
                </div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-between align-items-stretch">  
            <div class="col-lg-4 col-md-12 pricing-box text-center light-purple-color"> 
                <div class="d-flex flex-column-reverse flex-lg-column">
                    <div class="sc-heading-area sc-mt-20 sc-mb-20 text-md-center text-start">
                        <h5 class="font-lg-20-bold font-16-normal">
                            Start your journey to finding emerging market leaders by tapping on
                            <a class="buy-now-btn" data-bs-target="#search-modal" data-bs-toggle="modal" href="#" 
                               data-product-id="<?= esc($product['id']) ?>" data-product-name="<?= esc($product['fld_title']) ?>" 
                               data-amount="<?= esc($product['fld_pricing']) ?>" 
                               data-sub-title="12 month subscription" 
                               data-expired-month="12" id="buyNowBtn"> 
                                Buy Now
                            </a> 
                        </h5>
                    </div>	
                    
                    <img src="images/product/empowering-01.svg">
                </div>
                
                <h3 class="sc-mb-0 font-lg-36-bold font-36-bold text-md-center text-start">
                    ₹<?= number_format($product['fld_pricing'], 0) ?>
                </h3>
                <p class="font-lg-18-normal font-18-medium text-md-center text-start">(12 month subscription)</p>
            </div>
            
            <div class="col-lg-8 col-md-12 dark-gray"> 
                <div class="text-center sc-mt-40">
                    <img src="images/product/price-iphone.svg">                   
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sc-service-section-three sc-pt-30 sc-md-pt-30 sc-pb-50 sc-md-pb-50" 
     style="background: #FFFFFF; background: linear-gradient(180deg,rgba(255, 255, 255, 1) 1%, rgba(255, 255, 255, 1) 24%, rgba(240, 240, 240, 1) 55%, rgba(253, 253, 253, 1) 81%, rgba(255, 255, 255, 1) 100%);">
    <div class="container">
        <div class="row sc-pt-0 sc-md-pt-0">
            <div class="col-lg-12 col-md-12">
                <div class="sc-heading-area sc-mb-40 text-start">
                    <h3 class="font-lg-40-bold font-24-bold">Explore our Products</h3>							
                </div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-between align-items-stretch">  
            <div class="pricing-wrapper">
                <!-- First column: Headings -->
                <div class="card-titans">
                    <div>
                        <div style="height:57px;"></div>
                        <h3>&nbsp;</h3>
                        <div class="rows">
                            <div><p>Research Framework</p></div>
                            <div>Market Cap focus</div>
                            <div>No. of ideas in a year</div>
                            <div>Holding period</div>
                            <div>Pricing</div>
                        </div>
                    </div>
                </div>

                <?php foreach ($allProducts as $productItem): ?>
                    <div class="card-titans">
                        <div>
                            <img src="images/product/titan-<?= $productItem['id'] == 1 ? '1' : '2' ?>.svg">
                            <h3><?= esc($productItem['fld_title']) ?></h3>
                            <div class="rows">
                                <div><p><?= esc($productItem['fld_research_framework']) ?></p></div>
                                <div><?= esc($productItem['fld_market_cap_focus']) ?></div>
                                <div><?= esc($productItem['fld_no_of_ideas']) ?></div>
                                <div><?= esc($productItem['fld_holding_period']) ?></div>
                                <div>Rs. <?= number_format($productItem['fld_pricing'], 0) ?>/year</div>
                            </div>
                        </div>
                        <div>     
                            <a class="w-100 sc-primary-btn btn-color-3 text-center buy-now-btn" href="#" 
                               data-product-id="<?= esc($productItem['id']) ?>" data-product-name="<?= esc($productItem['fld_title']) ?>" 
                               data-amount="<?= esc($productItem['fld_pricing']) ?>" 
                               data-sub-title="12 month subscription" 
                               data-expired-month="12" 
                               style="padding:10px 30px;">
                                Buy Now
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
.pricing-wrapper {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  width: 100%;
  overflow:hidden;
}

/* Card common */
.card-titans {
  background:#fff;
  border-radius: 8px;
  border:1px solid #ccc;
  padding:25px 20px;
  /*box-shadow:0 2px 8px rgba(0,0,0,0.06);*/
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  width: 100%; /* important for scroll on mobile */
}

.card-titans:first-child {
  background:transparent;
  border-radius: 8px;
  border:0px solid #ccc;
  padding:25px 20px;
  /*box-shadow:0 2px 8px rgba(0,0,0,0.06);*/
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  width: 100%; /* important for scroll on mobile */
}

.card-titans h3 {
  margin:0;
  font-size:24px;
  font-weight:700;
  margin-bottom:20px;
}

.card-titans p {
  margin:10px 0 0px;
  font-size:20px;
  font-weight:500;
  line-height:1.4;
  min-height:140px; /* ensures row alignment */
}

.card-titans .rows {
  display: flex;
  flex-direction: column;
  gap: 30px;
  margin-bottom: 20px;
  font-size:20px;
  font-weight:500;
  color:#222;
}
.card-titans:first-child .rows {
font-weight:700;
}
.card-titans:first-child p {
font-weight:700;
}
.price {
  font-weight:bold;
  margin-bottom:15px;
}

.card-titans button {
  border:none;
  background:#000;
  color:#fff;
  padding:10px 20px;
  border-radius:6px;
  cursor:pointer;
  font-weight:600;
}

/* Make first card sticky on mobile */
@media(max-width:900px){
  .pricing-wrapper {
    display: flex;
    overflow-x: auto;
	gap:0px;
  }
.card-titans h3 {
  margin:0;
  font-size:16px;
  font-weight:700;
  margin-bottom:20px;
}

.card-titans p {
  margin:10px 0 0px;
  font-size:14px;
  font-weight:500;
  line-height:1.4;
  min-height:80px; /* ensures row alignment */
}
  .card-titans:first-child {
    
    left: 0;
    top: 0;
    z-index: 10;
    background:transparent;
    flex-shrink: 0;
	width:190px;
	padding-left:0px;
  }
  
  .card-titans .rows {
  display: flex;
  flex-direction: column;
  gap: 30px;
  margin-bottom: 20px;
  font-size:14px;
  font-weight:500;
  color:#222;
}
.card-titans:first-child .rows {
font-weight:700;
font-size:13px;
}
  .card-titans {
    margin-left: 10px;
    flex-shrink: 0;
  }
}

</style>

<?= $this->include('front/footer') ?>