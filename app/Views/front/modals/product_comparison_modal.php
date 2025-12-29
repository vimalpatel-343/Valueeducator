<div id="titan-modal" class="modal fade titan-modal" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-top">
        <p class="font-lg-18-semibold sc-mb-0 sc-ml-0 sc-pl-0">Compare Products</p>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          Close <img src="<?= base_url('images/cancel.svg') ?>">
        </button>
      </div>

      <div class="modal-body">
        <div class="titan-comparison-wrapper">
          <!-- single scrollbar here -->
          <div class="scroll-sync-wrapper">
            <div class="titles-content-wrapper">
              <?php if (!empty($allProducts)): ?>
                <?php foreach ($allProducts as $product): ?>
                  <div class="titan-block">
                    <div class="title-titan font-lg-20-bold"><?= $product['fld_title'] ?></div>
                    <div class="content-wrapper">
                      <div class="content-row">
                        
                        <!-- Framework Section -->
                        <div class="content-block framework-section" data-section="framework">
                          <div class="titan-box hgt-180" style="display: flex; align-items: center; justify-content: center; margin:0px 0px 0px; ">
                            <p class="font-lg-16-normal"><?= $product['fld_research_framework'] ?? 'Research framework information not available' ?></p>
                          </div><!--titan-box-->
                        </div><!--framework-section-->
                        
                        <!-- Video Section -->
                        <div class="content-block video-section" data-section="video">          
                          <?php if (!empty($product['fld_video_url'])): ?>
                            <iframe src="<?= $product['fld_video_url'] ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" title="<?= $product['fld_title'] ?>" width="100%" height="350"></iframe>
                          <?php else: ?>
                            <div class="titan-box hgt-180 d-flex align-items-center justify-content-center">
                              <p class="font-lg-16-normal">Video not available</p>
                            </div>
                          <?php endif; ?>
                        </div>

                        <!-- Details Section -->
                        <div class="content-block details-section" data-section="details">
                          <div class="row">
                            <div class="col-xl-4 col-md-4 col-sm-4 col-4">
                              <div class="titan-box" style="margin:0px 0px 0px; padding:11px 16px; ">
                                <div class="d-flex align-items-center gap-3">
                                  <h3 class="text-lg-start text-center font-lg-16-normal font-16-normal sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0" style="color:#8D8D8D;">Market Cap focus</h3>
                                  <p class="more font-lg-20-bold sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0"><?= $product['fld_market_cap_focus'] ?? 'N/A' ?></p>
                                </div>
                              </div><!--titan-box-->
                              <div class="titan-box" style="margin:10px 0px 0px; padding:11px 16px;">
                                <div class="d-flex align-items-center gap-3">
                                  <h3 class="text-lg-start text-center font-lg-16-normal font-16-normal sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0" style="color:#8D8D8D;">No. of ideas</h3>
                                  <p class="more font-lg-20-bold sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0"><?= $product['fld_no_of_ideas'] ?? 'N/A' ?></p>
                                </div>
                              </div><!--titan-box-->
                              <div class="titan-box" style="margin:10px 0px 0px; padding:11px 16px; ">
                                <div class="d-flex align-items-center gap-3">
                                  <h3 class="text-lg-start text-center font-lg-16-normal font-16-normal sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0" style="color:#8D8D8D;">Holding period</h3>
                                  <p class="more font-lg-20-bold sc-mt-0 sc-md-mt-0 sc-mb-0 sc-md-mb-0"><?= $product['fld_holding_period'] ?? 'N/A' ?></p>
                                </div>
                              </div><!--titan-box-->
                            </div><!--col-xl-4-->
                            
                            <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                              <div class="titan-box d-flex justify-content-between align-items-center gap-3" style="margin:0px 0px 0px; padding:32px 0px;">
                                <?php if (!empty($product['features'])): ?>
                                  <?php 
                                  // Decode features JSON if it's a JSON string
                                  $features = is_array($product['features']) ? $product['features'] : json_decode($product['features'], true);
                                  ?>
                                  <?php if (!empty($features) && is_array($features)): ?>
                                    <?php foreach ($features as $feature): ?>
                                      <div class="text-center">
                                        <?php if (!empty($feature['fld_image'])): ?>
                                          <img src="<?= base_url($feature['fld_image']) ?>" style="width:47px;">
                                        <?php endif; ?>
                                        <p class="font-lg-16-semibold font-16-semibold"><?= $feature['fld_title'] ?? '' ?></p>
                                      </div>
                                    <?php endforeach; ?>
                                  <?php endif; ?>
                                <?php endif; ?>
                              </div><!--titan-box-->
                            </div><!--col-xl-8-->
                          </div><!--row-->
                        </div><!--details-section-->
                        
                        <!-- Pricing Section -->
                        <div class="content-block pricing-section" data-section="pricing">
                          <div class="row d-flex align-items-center">
                            <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                              <div class="titan-box" style="margin:0px 0px 0px; padding:16px 16px; background:#F0FFDF;">
                                <div class="text-center">                
                                  <h6 class="sc-mb-0 font-lg-36-bold font-36-bold text-center">₹<?= number_format($product['fld_pricing'], 2) ?></h6>
                                  <p class="font-lg-18-normal font-18-medium text-center sc-pt-0">(12 month subscription)</p>
                                  <a class="sc-primary-btn btn-color-3 text-center buy-now-btn" href="#" data-product-name="<?= $product['fld_title'] ?>" data-amount="<?= $product['fld_pricing'] ?>" data-sub-title="12 month subscription" data-expired-month="12" style="padding:10px 30px;">Buy Now</a>
                                </div>
                              </div><!--titan-box-->
                            </div><!--col-xl-8-->
                            <div class="col-xl-4 col-md-4 col-sm-4 col-4">
                              <?php if (!empty($product['images'])): ?>
                                <?php 
                                // Get the first image for the product
                                $images = is_array($product['images']) ? $product['images'] : json_decode($product['images'], true);
                                if (!empty($images) && is_array($images)): ?>
                                  <img src="<?= base_url($images[0]) ?>" alt="<?= $product['fld_title'] ?>" style="height: 200px;">
                                <?php endif; ?>
                              <?php endif; ?>
                            </div><!--col-xl-4-->
                          </div><!--row-->
                        </div><!--pricing-section-->
                        
                      </div><!--content-row-->
                    </div><!--content-wrapper-->
                  </div><!--titan-block-->
                <?php endforeach; ?>
              <?php endif; ?>
            </div><!--titles-content-wrapper-->
          </div><!--scroll-sync-wrapper-->
        </div><!--titan-comparison-wrapper-->
      </div><!--modal-body-->

      <!-- bottom tabs -->
      <div class="popup-tabs">
        <button class="tab-link active" data-target="framework">Framework</button>
        <button class="tab-link" data-target="video">Video</button>
        <button class="tab-link" data-target="details">Details</button>
        <button class="tab-link" data-target="pricing">Pricing</button>
      </div>
    </div><!--modal-content-->
  </div><!--modal-dialog-->
</div>
<style>
.titan-modal {
width:45%;
height:auto;
padding:0px 10px;
background:#fff;
position: fixed;
z-index:99999999!important;
left: 50%;
top: 50%;
-webkit-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);
overflow-y:hidden;
overflow:hidden;
border-radius:8px;
}

.titan-modal .modal-content {
  background: transparent;
 /* position: initial;*/
  border: 0;
  position: relative;
  overflow:hidden;
}
.titan-modal .modal-content .modal-header {
border-bottom:1px solid #ccc;
padding:5px 0px 15px!important;
}

.titan-modal .modal-dialog {
max-width:98%;
margin: 0 0.5rem;
padding:15px 0px;
}
.titan-modal button.close {
  background: none;
  border: none;
  border: none;
  position: absolute;
  /*top: 20px;*/
  right: 0px;
  z-index: 99;
  border:0px solid red;
  font-size:16px;
}

.modal-body {
  overflow-y: hidden;
  scroll-behavior: smooth;
  border:0px solid black;
  padding:0px;
}

/* Bottom tabs */
.popup-tabs {
  display: flex;
  justify-content: space-around;
  border-top: 1px solid #ddd;
  background: #EEE4FF;
  padding: 0px;
  border-radius: 12px;
  margin-top:10px;
}

.popup-tabs .tab-link {
  flex: 1;
  text-align: center;
  padding: 10px;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  font-size:14px;
  font-weight: 600;
  background: none;
  color:#121212;
}

.popup-tabs .tab-link.active {
  background:#9155F1;
  color: #fff;
}

.titan-comparison-wrapper {
  display: flex;
  flex-direction: column;
  gap: 0px;
  width: 100%;
  overflow: hidden;  
}

/* Container for single scroll */
.scroll-sync-wrapper {
  overflow-x: auto;
  overflow-y: hidden;
  scroll-behavior: smooth;
  padding-bottom: 0px;
}

/* Stack rows inside horizontally synced area */
.titles-content-wrapper {
  display: flex;
  flex-direction: column;
  gap: 0px;
  min-width: max-content;
}

.titan-block {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  position: relative;
  margin-bottom:0px;
}
.titan-box {
background:#F9F6FF;
padding:16px 16px;
margin:20px 0px;
border-radius:16px;
}
 .titan-box.hgt-180 {
    height: 180px;
}
.title-titan {
 /* width: 180px; */
  padding: 10px 0px;
  position: fixed;
  z-index: 3;
  display:block;
}


.content-wrapper {
  overflow-x: hidden;
  border:0px solid red;
  position:relative;
  margin-top:50px;
 
}

.content-row {
  display: flex;
  gap: 10px;
  min-width: max-content; 
  padding: 0px;
}

.content-block {
  /*min-width: 220px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 6px;
  background: #fafafa;
  text-align: center;*/
  flex-shrink: 0;
}

.framework-section {width:400px; }
.video-section { width:400px; }
.video-section iframe { width:100%; height:180px; }
.details-section { width:1400px;}
.pricing-section { width:570px; margin-right:0px; border:0px solid red;}
.pricing-section img {max-width:120px}

@media (min-width: 1499px) {
  .pricing-section  {
    margin-right: 0vw;
  }
}

/* prettier single scrollbar */
.scroll-sync-wrapper::-webkit-scrollbar {
  height: 10px;
}
.scroll-sync-wrapper::-webkit-scrollbar-thumb {
  background: #7a4dff;
  border-radius: 5px;
}
.scroll-sync-wrapper::-webkit-scrollbar-track {
  background: #eee;
}
@media (max-width:768px) {
.titan-modal {
width:100%;
height:82vh;
}
.scroll-sync-wrapper {
  overflow-x: auto;
  overflow-y: hidden;
  scroll-behavior: smooth;
  padding-bottom: 0px;
}
.pricing-section { width:350px; margin-right:0px;}
.pricing-section img {max-width:auto}
}
</style>
<script>
const scrollWrapper = document.querySelector('.scroll-sync-wrapper');
const tabs = document.querySelectorAll('.tab-link');

const titleWidth = document.querySelector('.title-titan')?.offsetWidth || 0;

let isProgrammaticScroll = false;

// Handle tab click
tabs.forEach(btn => {
  btn.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    const target = btn.getAttribute('data-target');
    const block = scrollWrapper.querySelector(`.content-block[data-section="${target}"]`);

    if (block) {
      let blockLeft = block.offsetLeft - titleWidth;
      const maxScroll = scrollWrapper.scrollWidth - scrollWrapper.clientWidth;

      if (target === "pricing") {
        blockLeft = maxScroll; // scroll all the way right
      }

      // Lock scroll handler
      isProgrammaticScroll = true;

      scrollWrapper.scrollTo({
        left: blockLeft,
        behavior: 'smooth'
      });

      // Unlock after ~500ms (duration of smooth scroll)
      setTimeout(() => {
        isProgrammaticScroll = false;
      }, 600);
    }
  });
});

// Auto-activate tab on manual scroll
scrollWrapper.addEventListener('scroll', () => {
  if (isProgrammaticScroll) return; // ignore programmatic scroll

  const blocks = scrollWrapper.querySelectorAll('.content-block[data-section]');
  let activeSection = null;

  blocks.forEach(block => {
    const blockLeft = block.offsetLeft - titleWidth;
    if (scrollWrapper.scrollLeft >= blockLeft - 10) {
      activeSection = block.getAttribute('data-section');
    }
  });

  if (scrollWrapper.scrollLeft + scrollWrapper.clientWidth >= scrollWrapper.scrollWidth - 5) {
    activeSection = "pricing";
  }

  if (activeSection) {
    tabs.forEach(t => {
      if (t.getAttribute('data-target') === activeSection) {
        t.classList.add('active');
      } else {
        t.classList.remove('active');
      }
    });
  }
});
</script>