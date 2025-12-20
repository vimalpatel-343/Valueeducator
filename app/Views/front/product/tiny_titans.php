<?= $this->include('front/header') ?>

<section class="sc-statistics-section-area sc-pt-20 sc-md-pt-0 sc-pb-50 sc-md-pb-0">
    <div class="container">
        <div class="row d-lg-flex justify-content-between align-items-center">
            <div class="col-lg-7 sc-statistics-area sc-mt-0 sc-md-mt-0">
                <h1 class="text-start sc-mt-20 sc-md-mb-20 sc-mb-20 font-lg-32-bold font-24-bold">
                    <?= esc($product['fld_title']) ?>
                </h1>
                
                <p class="sc-mb-20">
                    <?= $product['fld_description'] ?>
                </p>
            </div>
            
            <div class="col-lg-5 order-first order-md-0">
                <div class="sc-statistics-left-content">                               
                    <div class="sc-ab-image sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="250">
                        <img class="sc-border-radius" src="images/product/Icon_1.png" alt="" style="margin:0px auto;">
                    </div>								
                </div>
            </div>
        </div>
    </div>
</section>

<div class="sc-team-section-area light-purple-color sc-pb-0 sc-md-pb-0 sc-mt-0 sc-md-mt-0">
    <div class="container">
        <div class="row sc-pt-50 sc-md-pt-40">
            <div class="col-lg-12 col-md-12 sc-pb-50 text-md-center text-start">
                <h4 class="title-24 sc-mb-20 sc-mt-0 font-lg-24-bold font-16-bold">Watch this video to learn more about <?= esc($product['fld_title']) ?></h4>		
                
                <div class="video-wrapper">
                    <?php if (!empty($product['fld_video_url'])): ?>
                        <iframe src="<?= esc($product['fld_video_url']) ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" title="<?= esc($product['fld_title']) ?>" width="100%" height="350"></iframe>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="sc-statistics-section-area sc-pt-20 sc-md-pt-0 sc-pb-0 sc-md-pb-0" style="background:#F9F6FF;">
    <div class="container-fluid">
        <div class="row d-lg-flex justify-content-between align-items-center">
            <div class="col-lg-6">
                <div class="sc-statistics-left-content d-flex justify-content-center align-items-end">                               
                    <div class="sc-ab-image sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="250">
                        <img src="images/product/tiny-mobile.png" alt="" class="d-lg-block d-none" style="margin:0px auto;">
                    </div>								
                </div>
            </div>
            
            <div class="col-lg-6 sc-statistics-area sc-mt-0 sc-md-mt-0">
                <div class="row">
                    <!-- Left column -->
                    <div class="col-lg-6 d-flex flex-column">
                        <div class="order-1 order-lg-1">
                            <div class="white-box" style="padding:15px;">
                                <div class="sc-heading-area sc-mb-10 text-start">
                                    <h3 class="font-lg-20-bold font-20-bold sc-mb-0" style="text-align:left;">Latest Financial Report</h3>
                                    <span class="font-lg-14-normal" style="color:#8D8D8D;">Last updated on: 21st Jan, 2025</span>
                                </div>
                                
                                <div class="h-card-wrapper">
                                    <div class="h-card" style="background:#F9F6FF;">
                                        <div class="h-card-top">
                                            <div class="h-card-left">
                                                <img src="images/company-logo-1.jpg">
                                                <span class="title">XYZ chemicals</span>
                                            </div>
                                            <div class="h-card-right">
                                                <i class="icon"><img src="images/icon-chemical.svg"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-card-date" style="margin-bottom:0px;">07th Dec, 2024</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-3 order-lg-2">
                            <div class="white-box" style="padding:15px;">
                                <div class="sc-heading-area sc-mb-10 text-left">
                                    <h3 class="font-lg-20-bold font-20-bold sc-mb-0" style="text-align:left;">Scuttlebutt notes</h3>
                                </div>
                                
                                <div class="sc-mb-0" style="border:0px;">
                                    <img src="images/product/img-notes.svg" style="width:100%">                                   
                                </div>
                                <ul class="liststyle1 mt-3">
                                    <li>Management Interaction & Insights</li>
                                    <li>Industry & Ecosystem Feedback</li>
                                    <li>Ground-Level Check</li>
                                    <li>Growth Triggers & Risks</li>
                                    <li>Red Flags</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right column -->
                    <div class="col-lg-6 d-flex flex-column">
                        <div class="order-2 order-lg-1">
                            <div class="white-box" style="padding:15px;">
                                <div class="sc-heading-area sc-mb-10 text-left">
                                    <h3 class="font-lg-20-bold font-20-bold sc-mb-0" style="text-align:left;">Management interview</h3>
                                </div>
                                
                                <div class="sc-mb-0" style="border:0px;">
                                    <div class="video-container">
                                        <img src="images/management_interview_tiny_titans.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-4 order-lg-2">
                            <div class="white-box" style="padding:15px;">
                                <div class="sc-heading-area sc-mb-10 text-start">
                                    <h3 class="font-lg-20-bold font-20-bold sc-mb-0" style="text-align:left;">Quarterly Model Portfolio Updates</h3>
                                </div>
                                
                                <div class="row sc-mt-12">
                                    <div class="col-lg-6 col-6">
                                        <div class="gray-card">
                                            <div class="icon">
                                                <img src="images/product/alarm-on.svg">
                                            </div>
                                            <h2>Q1</h2>
                                            <p>2026</p>
                                        </div>
                                        <div class="gray-card faded">
                                            <h2>Q3</h2>
                                            <p>2026</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-6">
                                        <div class="gray-card">
                                            <div class="icon">
                                                <img src="images/product/alarm-on.svg">
                                            </div>
                                            <h2>Q2</h2>
                                            <p>2026</p>
                                        </div>
                                        <div class="gray-card faded">
                                            <h2>Q4</h2>
                                            <p>2026</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="sc-team-section-area sc-pb-40 sc-md-pb-20 sc-md-mt-0">
    <div class="container">
        <div class="row sc-pt-40 sc-md-pt-40">
            <div class="col-lg-12 col-md-12 d-none d-lg-block">
                <div class="sc-heading-area sc-mb-25 text-center">
                    <h3 class="font-lg-32-bold font-20-bold">Product Features</h3>
                </div>
            </div>
        </div>
        
        <div class="row features-row" id="featuresContainer">
            <?php if (!empty($features)): ?>
                <!-- First Feature - Vertical Layout (Left Column) -->
                <div class="col-lg-4 col-md-12 sc-pb-20">
                    <div class="sc-team-item no-pad text-center text-lg-start min-hgt-auto feature-left" id="featureLeft">
                        <div class="item-img sc-mt-30 sc-mb-30">
                            <div class="text-center">
                                <a href="#">
                                    <?php if (!empty($features[0]['fld_image'])): ?>
                                        <img src="<?= base_url($features[0]['fld_image']) ?>" class="no-hover" alt="">
                                    <?php else: ?>
                                        <img src="images/product/img-product-1.svg" class="no-hover" alt="">
                                    <?php endif; ?>
                                </a>
                            </div>
                            
                            <div class="sc-team-content sc-mt-15 text-start" style="margin-top:30px;">
                                <h3 class="font-lg-24-bold font-20-bold">
                                    <?= esc($features[0]['fld_title']) ?>
                                </h3>
                                <ul class="liststyle1">
                                    <?php 
                                    // Convert description to list items if it contains bullet points
                                    $description = $features[0]['fld_description'];
                                    if (strpos($description, '<li>') !== false) {
                                        echo $description;
                                    } else {
                                        // Split description by new lines or create a single list item
                                        $lines = explode("\n", $description);
                                        foreach ($lines as $line) {
                                            if (trim($line)) {
                                                echo '<li class="font-lg-16-normal font-14-normal" style="color:#121212;">' . trim($line) . '</li>';
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Remaining Features - Horizontal Layout (Right Column) -->
                <div class="col-lg-8 col-md-12 sc-pb-20">
                    <div class="feature-right" id="featureRight">
                        <div class="row">
                            <?php 
                            // Start from the second feature (index 1)
                            for ($i = 1; $i < count($features); $i++): 
                            ?>
                                <div class="col-lg-12 sc-team-item no-pad text-start text-lg-start min-hgt-auto sc-mb-20 feature-item">
                                    <div class="d-flex flex-column flex-lg-row align-items-center align-items-lg-start text-start text-lg-start">
                                        <div class="team-image text-center" style="width:180px;">
                                            <a href="#">
                                                <?php if (!empty($features[$i]['fld_image'])): ?>
                                                    <img src="<?= base_url($features[$i]['fld_image']) ?>" class="no-hover" alt="">
                                                <?php else: ?>
                                                    <img src="images/product/img-titan-<?= $i+1 ?>.png" class="no-hover" alt="">
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        
                                        <div class="sc-team-content" style="margin-top:0;">
                                            <h4 class="font-lg-24-bold font-20-bold">
                                                <?= esc($features[$i]['fld_title']) ?>
                                            </h4>
                                            <span class="font-lg-16-normal font-14-normal" style="color:#121212;">
                                                <?= $features[$i]['fld_description'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Default content if no features exist -->
                <div class="col-12 text-center">
                    <p class="font-lg-18-normal font-14-normal">No features available for this product.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="row sc-pt-50 sc-md-pt-40">
            <div class="col-lg-12 col-md-12 d-none d-lg-block">
                <div class="sc-heading-area sc-mb-55 text-start">
                    <h3 class="font-lg-40-bold font-20-bold">Built for Serious SME Investors</h3>
                    <p class="text-start font-lg-32-bold font-14-normal" style="font-weight:400; line-height:40px;">
                        A premium community designed to empower HNIs and experienced investors with research-led conviction in the SME space.
                    </p>	
                </div>
            </div>
        </div>
    </div>
    
    <div class="gallery-wrapper">
        <div class="gallery">
            <img src="images/product/g22.jpeg" alt="" class="wide">
            <img src="images/product/g2.png" alt="">
            <img src="images/product/g3.png" class="wide" alt="">
            <img src="images/product/g4.png" alt="" class="wide">
            <img src="images/product/g5.png" alt="">
            <img src="images/product/g6.png" class="wide" alt="">
            <img src="images/product/g77.jpeg" class="wide" alt="">
            <img src="images/product/g7.png" alt="">
            <img src="images/product/g11.jpeg" class="wide" alt="">
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
                            Be part of the journey to uncover tomorrow’s SME leaders today by tapping on
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
                    <img src="images/product/black-titanium.svg">                   
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
.features-row {
    display: flex;
    flex-wrap: wrap;
}

.feature-left {
    transition: height 0.3s ease;
}

.feature-right {
    /* No special styles needed */
}

.feature-item {
    margin-bottom: 20px;
}

/* Ensure the content takes up the full height */
.sc-team-item {
    display: flex;
    flex-direction: column;
}

.item-img {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.sc-team-content {
    flex: 1;
}

/* For mobile responsiveness */
@media (max-width: 991px) {
    .feature-left {
        height: auto !important;
    }
}
.font-lg-24-normal {
font-size:24px!important;
font-weight:400!important;
}
@media (max-width: 768px) {
.font-18-medium {
font-size:18px!important;
font-weight:500!important;
line-height:20px!important;
}
}
		.liststyle1 {
		padding:5px;
		margin:0px;
		position:relative;
		}
		.liststyle1 li {
		position:relative;
		font-size:16px;
		color:#121212;
		
		list-style-type:none;
		padding-left:14px;
		line-height:20px;
		}
		.liststyle1 li:before{
	position:absolute;
	content:'\f111';
	left:0px;
	top:2px;
	color:#121212;
	font-size:4px;
	font-weight:500;
	font-family: 'FontAwesome';
}

.liststyle1 li.color-gray {
color:#8D8D8D;
}
.liststyle1 li.color-gray:before{
color:#8D8D8D;
}
	.gray-card {
    width: 100%;
    height: 110px;
    background: #fafafa;
    border-radius: 16px;
    /*box-shadow: 0 2px 6px rgba(0,0,0,0.1);*/
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    text-align: center;
	margin-bottom:10px;
  }

.gray-card.faded::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255,255,255,0.6); /* white semi-transparent layer */
  border-radius: 16px;
  pointer-events: none; /* so clicks still work if needed */
}
  .gray-card h2 {
    font-size: 28px;
    margin: 0;
    font-weight: 600;
    color: #000;
  }

  .gray-card p {
    margin: 0px 0 0;
    font-size: 16px;
	font-weight:400;
    color: #000;
  }

  /* Icon circle */
  .gray-card .icon {
    position: absolute;
    top: 8px;
    right: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 16px;
  }	
  
  	
.sc-team-item .team-image {
  flex: 0 0 180px;   /* fixed width column for images */
  max-width: 180px;
}

.sc-team-item .team-image img {
  width: 80%;
  height: auto;
  display: block;
}

 .gallery-wrapper {
    width: 100%;
    overflow: hidden;
    padding: 20px 0;
    display: flex;
    justify-content: center; /* center the gallery */
  }

 .gallery {
  display: grid;
  grid-auto-flow: column;           /* fill columns first, not rows */
  grid-template-rows: repeat(2, 200px); /* always 2 rows */
  gap: 20px;
  margin:0px -100px;
}

.gallery img {
  height: 200px;
  width: 100%;          /* take full column width */
  object-fit: cover;
  border-radius: 12px;
}
.gallery img.wide {
  grid-column: span 2; /* this image takes 2 columns */
}

	.video-wrapper {
    width: 100%;
    height: 650px; 
    overflow: hidden;
}

.video-wrapper iframe {
    width: 100%;
    height: 100%;
    border: 0;
}

/* Mobile view */
@media (max-width: 768px) {
    .video-wrapper {
        height: 250px !important;
    }

    .video-wrapper iframe {
        height: 100% !important;
    }
}
</style>
<?= $this->include('front/footer') ?>