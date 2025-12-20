<?= $this->include('front/header') ?>

<?php if (!$hasAccess): ?>
    <!-- Buy Now Box for non-subscribers -->
    <div class="sc-faq-style sc-pt-0 sc-mb-0 sc-md-pt-0 sc-pb-20 sc-md-pb-20 pt-2">
        <div class="container">
            <div class="row sc-mt-50 sc-md-mt-0">
                <div class="col-lg-12 col-md-12">
                    <div class="row sc-pt-0 sc-md-pt-30 sc-pb-20 sc-md-pb-20">
                        <div class="col-lg-12 col-md-12">
                            <div class="offer-strip">
                                <p class="title-24 sc-lg-mr-26 font-lg-20-bold text-center text-lg-start">
                                    Start your journey to finding emerging market leaders by tapping on <a href="#">Buy Now</a>
                                </p>
                                <div class="right-content bottom-row">
                                    <h2 class="title-24 font-lg-36-bold text-center sc-pt-10">
                                        ₹<?= number_format($productPricing, 0) ?>
                                        <span class="txt2 font-lg-18-normal" style="font-weight:500; margin-top:0px; padding-top:0px;">
                                            (12 month subscription)
                                        </span>
                                    </h2>
                                    <a class="sc-primary-btn btn-color-5 font-lg-20-normal buy-now-btn" data-bs-target="#payment-search-modal" data-bs-toggle="modal" href="#" data-product-id="<?= $product['id'] ?>" data-product-name="<?= $product['fld_title'] ?>" data-amount="<?= $productPricing ?>" data-sub-title="12 month subscription" data-expired-month="12">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="sc-pt-30 sc-pb-30 light-purple-color">
    <div class="container">
        <div class="row">
            <!-- Latest Recommendations -->
            <div class="col-lg-8 col-12 sc-mb-20 sc-lg-mb-0">
                <div class="text-center light-green sc-mb-0 sc-pt-20 sc-pb-10" style="border-radius:8px 8px 0px 0px;">
                    <h3 class="font-lg-18-semibold">Latest Recommendations</h3>
                </div>
                <?php if (!$hasAccess): ?>
                    <img src="<?= base_url('uploads/blur/e1.png') ?>" alt="Subscribe to view content" style="width: 100%; height: 300px;">
                <?php else: ?>
                    <div class="table-responsive portfolio-tbl" style="height:300px;">
                        <table class="table" style="margin-bottom:0px;">
                            <thead class="table__thead bright-green">
                                <tr>
                                    <th class="table__th" style="padding:8px 8px!important;">S.No.</th>
                                    <th class="table__th" style="padding:8px 8px!important;">Stock Name</th>
                                    <th class="table__th" style="padding:8px 8px!important;">Date of Recommendation</th>
                                    <th class="table__th" style="padding:8px 8px!important;">Price at Recommendation</th>
                                    <th class="table__th" style="padding:8px 8px!important;">Allocation</th>
                                    <th class="table__th text-center" style="padding:8px 8px!important;">Action</th>
                                    <th class="table__th text-center" style="padding:8px 8px!important;">Report</th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody" style="border-top:0px; background:#fff;">
                                <?php if (!empty($latestRecommendations)): ?>
                                    <?php $i = 1; foreach ($latestRecommendations as $stock): ?>
                                        <tr class="table-row">
                                            <td class="table-row__td"><?= $i ?></td>
                                            <td class="table-row__td">
                                                <p class="table-row__name"><?= $stock['fld_stock_name'] ?></p>
                                            </td>
                                            <td data-column="Policy" class="table-row__td">
                                                <p class="table-row__p-status"><?= date('jS M, Y', strtotime($stock['fld_date_of_recommendation'])) ?></p>  
                                            </td>
                                            <td data-column="Policy status" class="table-row__td">
                                                <p class="table-row__p-status">Rs <?= format_price($stock['fld_price_at_recommendation']) ?></p>
                                            </td>
                                            <td data-column="Destination" class="table-row__td">
                                                <p class="table-row__p-status status--purple"><?= format_price($stock['fld_allocation']) ?>%</p>
                                            </td>
                                            <td data-column="Status" class="table-row__td text-center">
                                                <a class="sc-primary-btn less-pad btn-color-<?= strtolower($stock['fld_action']) == 'buy' ? '6' : '8' ?> text-center sc-mt-5 sc-mb-0" href="javascript:void(0);" style="cursor: auto;"><?= $stock['fld_action'] ?></a>
                                            </td>
                                            <td class="table-row__td text-center">
                                                <p class="table-row__progress status--blue">
                                                    <?php if (!empty($stock['fld_report_url'])): ?>
                                                        <a href="#" class="open-pdf" data-pdf="<?= base_url($stock['fld_report_url']) ?>" data-stock="<?= $stock['fld_stock_name'] ?>">
                                                            <img src="<?= base_url('images/icon-report.svg') ?>">
                                                        </a>
                                                    <?php endif; ?>
                                                </p>   
                                            </td>
                                        </tr>
                                    <?php $i++; endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No recommendations available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- How to use? (Video) -->
            <div class="col-lg-4 col-12">
                <div class="sidebar-popular-post sc-mb-20 sc-lg-mb-0" style="height:360px;">
                    <div class="sidebar-title sc-mb-10">
                        <h3 class="font-lg-20-bold sc-mb-0">How to use?</h3>
                        <p class="font-lg-16-normal">Your ultimate guide for navigating "<?= $product['fld_title'] ?>"</p>
                    </div>
                    <div class="sc-mb-0">
                        <?php if (!$hasAccess): ?>
                            <img src="<?= base_url('uploads/blur/e2.png') ?>" alt="Subscribe to view content" style="width: 100%; height: 100%;">
                        <?php else: ?>
                            <div class="video-container">
                                <!-- Embed video here - assuming product has a video URL -->
                                <?php if (!empty($product['fld_how_to_use_url'])): ?>
                                    <div class="video-embed-container">
                                        <iframe 
                                            src="<?= $product['fld_how_to_use_url'] ?>" 
                                            width="100%" 
                                            height="250" 
                                            frameborder="0" 
                                            allow="autoplay; fullscreen; picture-in-picture" 
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                <?php else: ?>
                                    <p>No video available</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Stock Updates -->
            <div class="col-lg-4 col-12">
                <div class="sidebar-popular-post sc-mb-20" style="height:350px;">
                    <div class="sidebar-title sc-mb-0 d-flex justify-content-between align-items-center">
                        <h3 class="font-lg-20-bold sc-mb-0">Stock Updates</h3>
                        <?php if ($hasAccess): ?>
                            <a href="<?= base_url('portfolio-emerging-titan') ?>" class="font-lg-16-bold font-purple" target="_blank">See All</a>
                        <?php else: ?>
                            <a href="#" class="font-lg-16-bold font-purple">See All</a>
                        <?php endif; ?>
                    </div>

                    <?php if (!$hasAccess): ?>
                        <img src="<?= base_url('uploads/blur/e3.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                    <?php else: ?>
                        <p class="font-lg-14-normal font-dark-grey sc-mt-0 sc-mb-0">Last updated on <?= date('d/m/Y') ?></p>
                        
                        <?php if (!empty($stockUpdates)): ?>
                            <?php foreach ($stockUpdates as $update): ?>
                                <div class="white-box d-flex justify-content-between align-items-baseline" style="background:#F7F7F7; border:0px;">
                                    <h3 class="font-lg-16-bold company-name">
                                        <a href="#" class="stock-link" data-stock-id="<?= $update['fld_stock_id'] ?>" data-stock-name="<?= htmlspecialchars($update['fld_stock_name']) ?>">
                                            <?= htmlspecialchars($update['fld_stock_name']) ?>
                                        </a>
                                    </h3>
                                    <h3 class="font-lg-14-normal font-green chemical" style="margin-right:5px; margin-left:auto; text-align:right;">
                                        <a href="#" class="stock-link" data-product-id="1" data-stock-id="<?= $update['fld_stock_id'] ?>" data-stock-name="<?= htmlspecialchars($update['fld_stock_name']) ?>" style="color:#00A651;">
                                            <img src="<?= base_url('images/icon-bell.svg') ?>"> New Update
                                        </a>
                                    </h3>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No stock updates available</p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($total_count - count($stockUpdates) > 0) { ?>
                        <p class="font-lg-16-semibold pt-2 sc-mt-0 sc-mb-0">+<?= ($total_count - count($stockUpdates)); ?> more stock</p>
                    <?php } ?>
                </div>
                
            </div>
            
            <!-- Quarterly Model Portfolio Updates -->
            <div class="col-lg-4 col-12">
                <?php if (!$hasAccess): ?>
                    <div class="sidebar-popular-post sc-mb-20" style="height:350px;">
                        <div class="sidebar-title gap-4 sc-mb-0 d-flex justify-content-between align-items-top">
                            <h3 class="font-lg-20-bold sc-mb-5">Quarterly Model Portfolio Updates</h3>
                            <a href="#" class="font-lg-16-bold font-purple" style="white-space: nowrap;">See All</a>
                        </div>
                        <img src="<?= base_url('uploads/blur/e4.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                    </div>                    
                <?php else: ?>
                    <?php if (!empty($quarterlyUpdates)): ?>
                        <?php foreach ($quarterlyUpdates as $update): ?>
                            <div class="sidebar-popular-post sc-mb-20" style="height:350px;">
                                <div class="sidebar-title gap-4 sc-mb-0 d-flex justify-content-between align-items-top">
                                    <h3 class="font-lg-20-bold sc-mb-5">Quarterly Model Portfolio Updates</h3>
                                    <a href="<?= base_url('quarterly-updates-emerging-titan') ?>" class="font-lg-16-bold font-purple" style="white-space: nowrap;" target="_blank">See All</a>
                                </div>
                                <p class="font-lg-14-normal font-green sc-mt-0 sc-mb-20">
                                    <img src="<?= base_url('images/icon-bell.svg') ?>"> New Update on <?= date('d/m/Y', strtotime($update['fld_created_at'])) ?>
                                </p>
                                <div class="sc-mb-0">
                                    <div class="video-container">
                                        <?php if (!empty($update['fld_video_url'])): ?>
                                            <div class="video-embed-container">
                                                <iframe 
                                                    src="<?= $update['fld_video_url'] ?>" 
                                                    width="100%" 
                                                    height="250" 
                                                    frameborder="0" 
                                                    allow="autoplay; fullscreen; picture-in-picture" 
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        <?php else: ?>
                                            <p>No video available</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="sidebar-popular-post sc-mb-20" style="height:350px;">
                            <div class="sidebar-title gap-4 sc-mb-0 d-flex justify-content-between align-items-top">
                                <h3 class="font-lg-20-bold sc-mb-5">Quarterly Model Portfolio Updates</h3>
                                <a href="<?= base_url('quarterly-updates-emerging-titan') ?>" class="font-lg-16-bold font-purple" style="white-space: nowrap;" target="_blank">See All</a>
                            </div>
                            <p>No quarterly updates available</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <!-- Management Interviews -->
            <div class="col-lg-4 col-12">
                <?php if (!$hasAccess): ?>
                    <div class="sidebar-popular-post sc-mb-20" style="height:350px;">
                        <div class="sidebar-title gap-4 sc-mb-0 d-flex justify-content-between align-items-top">
                            <h3 class="font-lg-20-bold sc-mb-0">Management Interviews</h3>
                            <a href="#" class="font-lg-16-bold font-purple" style="white-space: nowrap;">See All</a>
                        </div>
                        <img src="<?= base_url('uploads/blur/e5.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                    </div>                    
                <?php else: ?>
                    <?php if (!empty($managementInterviews)): ?>
                        <?php foreach ($managementInterviews as $interview): ?>
                            <div class="sidebar-popular-post sc-mb-20" style="height:350px;">
                                <div class="sidebar-title sc-mb-5 gap-4 d-flex justify-content-between align-items-top">
                                    <h3 class="font-lg-20-bold sc-mb-0">Management Interviews</h3>
                                    <a href="<?= base_url('management-interviews-emerging-titan') ?>" class="font-lg-16-bold font-purple" style="white-space: nowrap;" target="_blank">See All</a>
                                </div>
                                <p class="font-lg-14-normal font-dark-grey sc-mt-0 sc-mb-20">Last Update on <?= date('d/m/Y', strtotime($interview['fld_created_at'])) ?></p>
                                <div class="sc-mb-0">
                                    <div class="video-container" data-index="1">
                                        <?php if (!empty($interview['fld_video_url'])): ?>
                                            <div class="video-embed-container">
                                                <iframe 
                                                    src="<?= $interview['fld_video_url'] ?>" 
                                                    width="100%" 
                                                    height="250" 
                                                    frameborder="0" 
                                                    allow="autoplay; fullscreen; picture-in-picture" 
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        <?php else: ?>
                                            <p>No video available</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="sidebar-popular-post sc-mb-20" style="height:350px;">
                            <div class="sidebar-title sc-mb-5 gap-4 d-flex justify-content-between align-items-top">
                                <h3 class="font-lg-20-bold sc-mb-0">Management Interviews</h3>
                                <a href="<?= base_url('management-interviews-emerging-titan') ?>" class="font-lg-16-bold font-purple" style="white-space: nowrap;" target="_blank">See All</a>
                            </div>
                            <p>No management interviews available</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <!-- Scuttlebutt Notes -->
            <div class="col-lg-4 col-12">
                <div class="sidebar-popular-post sc-mb-20" style="height:400px;">
                    <div class="sidebar-title sc-mb-5 d-flex justify-content-between align-items-center">
                        <h3 class="font-lg-20-bold sc-mb-0">Scuttlebutt Notes</h3>
                        <?php if ($hasAccess): ?>
                            <a href="javascript:void(0);" data-product="1" class="font-lg-16-bold font-purple scuttlebutt-trigger" data-bs-toggle="modal" data-bs-target="#scuttlebut-modal">See All</a>
                        <?php else: ?>
                            <a href="javascript:void(0);" class="font-lg-16-bold font-purple">See All</a>
                        <?php endif; ?>
                    </div>
                    <?php if (!$hasAccess): ?>
                        <img src="<?= base_url('uploads/blur/e6.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                    <?php else: ?>
                        <p class="font-lg-14-normal font-green sc-mt-0 sc-mb-10"><img src="images/icon-bell.svg"> New Update on 23/10/2025</p>
                        <p class="font-lg-14-normal font-black sc-mt-0 sc-mb-10"><b></b></p>
                        <div class="sc-mb-10 " style="border:0px;">
                            <img src="images/scuttlebut_logo/scuttlebut1.nseindia.com.png" class="bdr-radii" style="width:100%;">                                   
                        </div>
                        <p>In April&nbsp;2025, We had a management meet with&nbsp;<strong>Tara Chand Infralogistic Solutions Ltd</strong> attended by Himanshu Aggarwal,&nbsp;WTD&nbsp;&amp; CFO.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Latest Substack Updates -->
            <div class="col-lg-4 col-12">
                <div class="sidebar-popular-post sc-mb-20" style="height:400px;">
                    <div class="sidebar-title sc-mb-5 gap-4 d-flex justify-content-between align-items-top">
                        <h3 class="font-lg-20-bold sc-mb-0">Latest Substack Updates</h3>
                        <?php if ($hasAccess): ?>
                            <a href="<?= base_url('substack-updates') ?>" class="font-lg-16-bold font-purple" style="white-space: nowrap;" target="_blank">See All</a>
                        <?php else: ?>
                            <a href="#" class="font-lg-16-bold font-purple" style="white-space: nowrap;">See All</a>
                        <?php endif; ?>
                    </div>
                    <?php if (!$hasAccess): ?>
                        <img src="<?= base_url('uploads/blur/e7.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                    <?php else: ?>
                        <p class="font-lg-14-normal font-green sc-mt-0 sc-mb-20">
                            <img src="<?= base_url('images/icon-bell.svg') ?>"> New Update on 
                        </p>
                        <?php if (!empty($substackUpdates)): ?>
                            <?php foreach ($substackUpdates as $update): ?>
                                <div class="white-box d-flex gap-lg-3 justify-content-between align-items-center" style="margin-bottom:20px;">
                                    <div class="company-logo"><img src="<?= base_url($update['fld_image']) ?>"></div>
                                    <h3 class="font-lg-16-bold"><?= htmlspecialchars(strlen($update['fld_title']) > 30 ? substr($update['fld_title'], 0, 30) . '...' : $update['fld_title']) ?></h3>
                                    <a href="<?= $update['fld_url'] ?>" target="_blank" class="font-lg-14-normal font-green chemical" style="margin:0; margin-left:auto; text-align:right; cursor: pointer;">
                                        <img src="<?= base_url('images/blog.png') ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No substack updates available</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- YouTube videos section -->
            <div class="col-lg-4 col-md-6">
                <div class="sc-test-item sidebar-popular-post sc-mb-20" style="height:400px;">
                    <div class="sidebar-title sc-mb-5 d-flex justify-content-between align-items-center">
                        <h3 class="font-lg-20-bold sc-mb-0">YouTube videos</h3>
                        <?php if ($hasAccess): ?>
                            <a href="<?= base_url('youtube-videos') ?>" class="font-lg-16-bold font-purple" target="_blank">See All</a>
                        <?php else: ?>
                            <a href="#" class="font-lg-16-bold font-purple">See All</a>
                        <?php endif; ?>
                    </div>
                    <?php if (!$hasAccess): ?>
                        <img src="<?= base_url('uploads/blur/e8.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                    <?php else: ?>
                        <p class="font-lg-14-normal font-green sc-mt-0 sc-mb-20">
                            <img src="<?= base_url('images/icon-bell.svg') ?>"> New Update on 
                        </p>
                        <?php if (!empty($youtubeVideos)): ?>
                            <?php foreach ($youtubeVideos as $video): ?>
                                <a class="popup-youtube video-thumb" data-video-id="<?= $video['video_id'] ?>" href="https://www.youtube.com/watch?v=<?= $video['video_id'] ?>">
                                    <img src="https://img.youtube.com/vi/<?= $video['video_id'] ?>/hqdefault.jpg" alt="Video Thumbnail">
                                </a>
                                <div class="sc-auother-text d-flex align-items-center">
                                    <div class="sc-auother-header sc-mt-20">
                                        <div class="sc-mb-0">
                                            <h5 class="font-lg-20-bold"><?= $video['fld_title'] ?></h5>
                                            <!-- <p class="font-lg-16-normal"><?= $video['fld_description'] ?></p> -->
                                        </div>
                                        <p class="views font-lg-16-normal sc-pt-0 sc-mb-0">
                                            <?= shortNumber($video['fld_total_views']) ?> views &bull; Posted <?= time_ago(strtotime($video['fld_created_at'])) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No YouTube videos available</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Company Modal for Stock Updates -->
<div aria-hidden="true" id="company-modal" class="modal fade search-modal w-90" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="custom-modal-header">
                <div class="custom-modal-left">
                    <h3 class="font-lg-16-bold stock-modal-title"></h3>
                </div>
                <button type="button" class="custom-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    Close
                    <img src="<?= base_url('images/cancel.svg') ?>">
                </button>
            </div>
            <div class="tabs_wrapper">
                <!-- Stock update tabs will be loaded here -->
            </div>
        </div>
    </div>
</div>

<?= $this->include('front/footer') ?>