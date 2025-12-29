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
                                        ₹<?= number_format($productPricing, 2) ?>
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

<?php if (!empty($portfolioOverview['fld_disclaimer'])): ?>
<div class="sc-faq-style sc-pt-0 sc-mb-0 sc-md-pt-0 sc-pb-20 sc-md-pb-20 pt-2">
    <div class="container">
        <div class="row sc-mt-50 sc-md-mt-0">
            <div class="col-lg-12 col-md-12">
                <?php if (!$hasAccess): ?>
                    <img src="<?= base_url('uploads/blur/p1.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                <?php else: ?>
                    <div id="faqAccordion" class="accordion">
                        <div class="accordion-item sc-xs-mt-20" style="margin-bottom:20px;">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Disclaimer
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="font-lg-16-normal sc-mb-0"><?= nl2br(htmlspecialchars($portfolioOverview['fld_disclaimer'])) ?></p>
                                </div>
                            </div> 
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="sc-team-section-area sc-mt-0 sc-pb-30 sc-md-pb-30 sc-md-pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="d-flex align-items-center">
                    <img src="<?= base_url('images/icon-plan.svg') ?>" style="width:10%;" />
                    <h2 style="margin-left:10px;"><span class="font-lg-20-bold"><?= $product['fld_title'] ?></span></h2>
                </div>
                
                <?php if (!$hasAccess): ?>
                    <img src="<?= base_url('uploads/blur/p7.png') ?>" alt="Subscribe to view content" style="width: 100%; height: 300px;">
                <?php else: ?>
                    <p class="font-lg-16-normal sc-mt-10">                        
                        <?= $product['fld_description_paid'] ?? 'Emerging Titans is a research service focused on small and mid-cap stocks with strong growth potential.' ?>                        
                    </p>
                    <div class="d-none d-lg-block">
                        <p class="font-lg-16-bold sc-mb-0 sc-pb-0">Portfolio Distribution 
                            <img src="<?= base_url('images/info.svg') ?>" />
                        </p>
                        <ul class="percentage-line">
                            <?php foreach ($portfolioDistribution as $category): ?>
                                <li style="width:<?= $category['fld_percentage'] ?>%"><?= $category['fld_category'] ?><span><?= (int)$category['fld_percentage'] ?>%</span></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-6 col-12">
                <p class="font-lg-16-bold sc-mb-0 sc-pb-0">Portfolio Overview</p>
                <?php if (!$hasAccess): ?>
                    <img src="<?= base_url('uploads/blur/p8.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                <?php else: ?>
                    <div class="white-box sc-mt-0 d-lg-flex justify-content-between align-items-center" style="padding:25px 0px 0px; margin-top:5px;">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-6" style="padding-right:0px;">
                                    <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Portfolio Allocation</h3>
                                    <p class="font-lg-16-bold sc-mb-20"><?= $portfolioOverview['fld_portfolio_allocation'] ?? '96' ?>%</p>
                                </div>

                                <div class="col-lg-6 col-6" style="padding-right:0px;">
                                    <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Cash</h3>
                                    <p class="font-lg-16-bold sc-mb-0"><?= $portfolioDistribution['fld_cash_percentage'] ?? '4' ?>%</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="white-box sc-mt-0 d-lg-flex justify-content-between align-items-center" style="padding:25px 0px 0px; margin-top:5px;">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-6" style="padding-right:0px;">
                                    <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Stocks</h3>
                                    <p class="font-lg-16-bold sc-mb-20"><?= $portfolioOverview['fld_stocks_count'] ?? '25' ?></p>
                                </div>

                                <div class="col-lg-6 col-6" style="padding-right:0px;">
                                    <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Rebalance Frequency</h3>
                                    <p class="font-lg-16-bold sc-mb-0"><?= $product['fld_rebalance_frequency'] ?? 'Quarterly' ?></p>
                                </div>

                                <div class="col-lg-6 col-6" style="padding-right:0px;">
                                    <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Last Rebalance</h3>
                                    <p class="font-lg-16-bold sc-mb-20"><?= date('M d, Y', strtotime($portfolioOverview['fld_last_rebalance'] ?? 'Dec 10, 2025')) ?></p>
                                </div>

                                <div class="col-lg-6 col-6" style="padding-right:0px;">
                                    <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Next Rebalance</h3>
                                    <p class="font-lg-16-bold sc-mb-0"><?= $product['fld_next_rebalance'] ?? 'Mar 2026' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quarterly Model Portfolio Updates -->
<?php if (!empty($quarterlyUpdates)): ?>
    <div class="sc-testimonial-section-three sc-pt-20 sc-pb-20">
        <div class="container outerbox" style="padding:20px;">
            <div class="sc-heading-area sc-mb-20 text-left">
                <div class="d-flex justify-content-between align-items-center sc-mb-0 sc-md-mb-0">
                    <h3 class="font-lg-20-bold font-20-bold sc-mb-0">Quarterly Model Portfolio Updates</h3>
                    <?php if ($hasAccess): ?>
                        <a href="<?= base_url('quarterly-updates-emerging-titan') ?>" class="more font-lg-16-bold">See All</a>
                    <?php else: ?>
                        <a href="#" class="more font-lg-16-bold">See All</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="row">
                <?php if (!$hasAccess): ?>
                    <img src="<?= base_url('uploads/blur/p3.png') ?>" alt="Subscribe to view content" style="width: 100%; height: 300px;">
                <?php else: ?>
                    <?php foreach ($quarterlyUpdates as $update): ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                            <div class="sidebar-popular-post">
                                <div class="sidebar-title sc-mb-10">
                                    <h3 class="font-lg-20-bold font-20-bold sc-mb-0"><?= htmlspecialchars($update['fld_title']) ?></h3>
                                    <p class="subheading">Last updated on: <?= date('d/m/Y', strtotime($update['fld_created_at'])) ?></p>
                                </div>
                                <div class="sc-mb-0">
                                    <div class="video-container">
                                        <iframe width="560" height="315" 
                                                src="<?= $update['fld_video_url'] ?>" 
                                                title="YouTube video player" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" 
                                                allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Latest Recommendations -->
<?php if (!empty($latestRecommendations)): ?>
<div class="sc-philosophy-area sc-md-pb-60 sc-md-mt-0">
    <div class="container">
        <div class="row sc-mb-20">
            <div class="col-lg-12">
                <div class="text-center light-green sc-mb-0 sc-pt-20 sc-pb-10">
                    <h3 class="font-lg-18-semibold">Latest Recommendations</h3>
                </div>
                <?php if (!$hasAccess): ?>
                    <img src="<?= base_url('uploads/blur/p4.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                <?php else: ?>
                    <div class="table-responsive portfolio-tbl">
                        <table class="table">
                            <thead class="table__thead bright-green">
                                <tr>
                                    <th class="table__th">No.</th>
                                    <th class="table__th">Stock Name</th>
                                    <th class="table__th">Date of Recommendation</th>
                                    <th class="table__th">Price at Recommendation</th>
                                    <th class="table__th">Allocation</th>
                                    <th class="table__th text-center">Action</th>
                                    <th class="table__th text-center">Report</th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody" style="border-top:0px;">
                                <?php $i=1; foreach ($latestRecommendations as $stock): ?>
                                    <tr class="table-row">
                                        <td class="table-row__td"><?= $i ?></td>
                                        <td class="table-row__td">
                                            <p class="table-row__name"><?= $stock['fld_stock_name'] ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Policy">
                                            <p class="table-row__p-status"><?= date('jS M, Y', strtotime($stock['fld_date_of_recommendation'])) ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Policy status">
                                            <p class="table-row__p-status">Rs <?= format_price($stock['fld_price_at_recommendation']) ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Destination">
                                            <p class="table-row__p-status status--purple"><?= format_price($stock['fld_allocation']) ?>%</p>
                                        </td>
                                        <td class="table-row__td text-center" data-column="Status">
                                            <a class="sc-primary-btn less-pad btn-color-<?= strtolower($stock['fld_action']) == 'buy' ? '6' : '8' ?> text-center sc-mt-5 sc-mb-0" href="javascript:void(0);" style="cursor: auto;"><?= $stock['fld_action'] ?></a>
                                        </td>
                                        <td class="table-row__td text-center" data-column="Progress">
                                            <?php if (!empty($stock['fld_report_url'])): ?>
                                                <a href="#" class="open-pdf" data-type="stock" data-file="<?= basename($stock['fld_report_url']) ?>" data-stock="<?= $stock['fld_stock_name'] ?>">
                                                    <img src="<?= base_url('images/icon-report.svg') ?>" />
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Model Portfolio -->
<?php if (!empty($modelPortfolio)): ?>
<div class="sc-philosophy-area sc-md-pb-60 sc-md-mt-0">
    <div class="container">
        <div class="row sc-mb-20">
            <div class="col-lg-12">
                <div class="text-center dark-gray sc-mb-0 sc-pt-20 sc-pb-10">
                    <h3 class="font-lg-18-semibold">Model Portfolio</h3>
                    <p class="font-lg-14-normal" style="color:#8D8D8D;">
                        <i>Current Market Price (CMP)<br>
                        Last updated on: <?= date('jS M, Y') ?></i>
                    </p>
                </div>

                <?php if (!$hasAccess): ?>
                    <img src="<?= base_url('uploads/blur/p5.png') ?>" alt="Subscribe to view content" style="width: 100%;">
                <?php else: ?>
                    <div class="table-responsive portfolio-tbl">
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th class="table__th" style="width: 5%;">No.</th>
                                    <th class="table__th" style="width: 15%;">Stock Name</th>
                                    <th class="table__th" style="width: 13%;">Date of Recommendation</th>
                                    <th class="table__th" style="width: 13%;">Price at Recommendation</th>
                                    <th class="table__th" style="width: 8%;">Allocation</th>
                                    <th class="table__th text-center" style="width: 8%;">Action</th>
                                    <th class="table__th" style="width: 8%;">CMP</th>
                                    <th class="table__th">Sector</th>
                                    <th class="table__th" style="width: 8%;">Returns</th>
                                    <th class="table__th" style="width: 8%;">Reports</th>
                                    <th class="table__th" style="width: 5%;">Update</th>
                                </tr>
                            </thead>
                            <tbody class="table__tbody" style="border-top:0px;">
                                <?php $i=1; foreach ($modelPortfolio as $stock): ?>
                                    <tr class="table-row">
                                        <td class="table-row__td"><?= $i ?></td>
                                        <td class="table-row__td">
                                            <p class="table-row__name"><?= $stock['fld_stock_name'] ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Policy">
                                            <p class="table-row__p-status"><?= date('jS M, Y', strtotime($stock['fld_date_of_recommendation'])) ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Policy status">
                                            <p class="table-row__p-status" style="text-align: center;">Rs <?= format_price($stock['fld_price_at_recommendation']) ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Destination">
                                            <p class="table-row__p-status status--purple"><?= format_price($stock['fld_allocation']) ?>%</p>
                                        </td>
                                        <td class="table-row__td text-center" data-column="Status">
                                            <a class="sc-primary-btn less-pad btn-color-<?= strtolower($stock['fld_action']) == 'buy' ? '6' : '8' ?> text-center sc-mt-5 sc-mb-0" href="javascript:void(0);" style="cursor: auto;"><?= $stock['fld_action'] ?></a>
                                        </td>
                                        <td class="table-row__td" data-column="Progress">
                                            <p class="table-row__p-status">Rs <?= format_price($stock['fld_cmp']) ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Progress">
                                            <p class="table-row__p-status status--normal font-lg-16-normal"><?= $stock['fld_sector'] ?></p>
                                        </td>
                                        <td class="table-row__td" data-column="Progress">
                                            <p class="table-row__progress status--<?= $stock['return_class'] ?>"><?= format_price($stock['return']) ?>%</p>
                                        </td>
                                        <td class="table-row__td" data-column="Progress">
                                            <?php if (!empty($stock['fld_report_url'])): ?>
                                                <a href="#" class="open-pdf" data-type="stock" data-file="<?= basename($stock['fld_report_url']) ?>" data-stock="<?= $stock['fld_stock_name'] ?>">
                                                    <img src="<?= base_url('images/icon-report.svg') ?>" />
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="table-row__td" data-column="Progress">
                                            <!-- Check if stock has updates -->
                                            <?php 
                                            $hasUpdates = false;
                                            foreach ($stockUpdates as $update) {
                                                if ($update['fld_stock_id'] == $stock['id']) {
                                                    $hasUpdates = true;
                                                    break;
                                                }
                                            }
                                            ?>
                                            <?php if ($hasUpdates): ?>
                                                <img src="<?= base_url('images/icon-bell.svg') ?>" width="24" class="stock-link" data-product-id="1" data-stock-id="<?= $stock['id'] ?>" data-stock-name="<?= htmlspecialchars($stock['fld_stock_name']) ?>" style="cursor: pointer;">
                                            <?php else: ?>
                                                <img src="<?= base_url('images/icon-bell.svg') ?>" width="24" style="opacity: 0.3; cursor: not-allowed; color: gray;">
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Rebalance Timeline -->
<?php if (!empty($rebalanceTimeline)): ?>
<div class="rebalance-wrapper sc-mb-40">
    <div class="container">
        <div class="text-center light-green sc-mb-0 sc-pt-20 sc-pb-10">
            <div class="header-row">
                <h3 class="font-lg-18-semibold">Rebalance Timeline</h3>
                <span class="popup-trigger" onClick="openPopup('popup')" id="openPopup"><i class="fa fa-expand"></i></span>
            </div>
        </div>

        <?php if (!$hasAccess): ?>
            <img src="<?= base_url('uploads/blur/p6.png') ?>" alt="Subscribe to view content" style="width: 100%;">
        <?php else: ?>
            <div class="rebalance-accordion" id="rebalanceAccordion" style="overflow-y: auto;height: 350px;">
                <div class="accordion-item-rebalance">
                    <div class="accordion-title tooltip-wrapper">
                        <span class="arrow"><i class="fa fa-angle-down font-black"></i></span> Portfolio Review 
                        <a href="#" onMouseOver="showDiv('content1')" onMouseOut="hideDiv('content1')">
                            <img src="<?= base_url('images/info.svg') ?>">
                        </a> 
                        <div id="content1" class="hidden-content-3 text-right">
                            <p>The portfolio will be reviewed as needed</p>
                        </div>
                    </div>
                </div>

                <?php foreach($rebalanceTimeline as $timeline): ?>
                    <div class="accordion-item-rebalance">
                        <div class="accordion-title">
                            <span class="arrow"><i class="fa fa-angle-down font-black"></i></span>
                            <span class="date"><?= date('j M, Y', strtotime($timeline['fld_date'])) ?></span>
                            <span class="change">
                                <span class="added"><strong>+ <?= $timeline['fld_constituents_plus'] ?></strong> | </span>
                                <span class="removed"><strong>- <?= $timeline['fld_constituents_minus'] ?></strong></span>
                                <span class="color-gray">&nbsp;Constituents</span>
                            </span>
                        </div>

                        <div class="accordion-body-rebalance" style="border:0px solid red; padding:10px;">
                            <div class="accordion-content">
                                <div class="accordion-left">
                                    <?php if (!empty($timeline['fld_factsheet_url'])): ?>
                                        <a href="#" class="open-pdf" data-type="rebalance" data-file="<?= basename($timeline['fld_factsheet_url']) ?>" data-stock="<?= date('j M, Y', strtotime($timeline['fld_date'])) ?>" style="color:#444;">
                                            <?php $otherFactsheetIconImage = $pageImages['other']['factsheet_icon'] ?? null; ?>
                                            <img src="<?= base_url($otherFactsheetIconImage['image_path'] ?? 'images/other/factsheet-icon.svg') ?>" alt="<?= esc($otherFactsheetIconImage['image_alt'] ?? 'Factsheet Icon') ?>" class="other-icon" loading="lazy">
                                        </a>
                                        <a href="#" class="open-pdf ms-2" data-type="rebalance" data-file="<?= basename($timeline['fld_factsheet_url']) ?>" data-stock="<?= date('j M, Y', strtotime($timeline['fld_date'])) ?>" style="color:#444;">
                                            <span class="factsheet-text">Factsheet</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="accordion-right">
                                    <?php if (!empty($timeline['fld_description'])): ?>
                                        <?= $timeline['fld_description']; ?>
                                    <?php else: ?>
                                        <p>No rebalance details available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Mobile Popup for Rebalance Timeline -->
<div class="rebalance-popup" id="popup">
    <div class="rebalance-popup-content">
        <div class="rebalance-header">
            <div class="header-row">
                <h3 class="font-lg-18-semibold font-18-medium">Rebalance Timeline</h3>
                <span class="popup-trigger" id="openPopup"><i class="fa fa-expand"></i></span>
            </div>
        </div>
        <div class="rebalance-accordion" id="mobileAccordion"></div>
        <button class="popup-close-btn" id="closeBtn">Close</button>
    </div>
</div>

<!-- Stock Updates Modal -->
<div aria-hidden="true" id="company-modal" class="modal fade search-modal w-90" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="d-flex gap-2 justify-content align-items-center">
                <h3 class="font-lg-16-bold stock-modal-title"></h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    Close
                    <img src="<?= base_url('images/cancel.svg') ?>">
                </button>
            </div>
            <div class="tabs_wrapper"></div>
        </div>
    </div>
</div>

<?= $this->include('front/footer') ?>

<script>
    // Accordion functionality
    document.addEventListener("DOMContentLoaded", function() {
        const accordionItems = document.querySelectorAll('.accordion-item-rebalance');
        
        accordionItems.forEach(item => {
            const title = item.querySelector('.accordion-title');
            const body = item.querySelector('.accordion-body-rebalance');
            
            if (body) {
                body.style.maxHeight = '0px';
                body.style.overflow = 'hidden';
                body.style.padding = '0px 15px';
            }
            
            title.addEventListener('click', function() {
                const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';
                
                // Close all other accordions
                accordionItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        const otherBody = otherItem.querySelector('.accordion-body-rebalance');
                        const otherTitle = otherItem.querySelector('.accordion-title');
                        if (otherBody) {
                            otherBody.style.maxHeight = '0px';
                            otherBody.style.padding = '0px 15px';
                            otherTitle.classList.remove('active');
                        }
                    }
                });
                
                // Toggle current accordion
                if (isOpen) {
                    body.style.maxHeight = '0px';
                    body.style.padding = '0px 15px';
                    title.classList.remove('active');
                } else {
                    body.style.maxHeight = body.scrollHeight + 'px';
                    body.style.padding = '0px 15px 15px';
                    title.classList.add('active');
                }
            });
        });
        
        // Mobile popup functionality
        const popup = document.getElementById("popup");
        const openBtn = document.getElementById("openPopup");
        const closeBtn = document.getElementById("closeBtn");
        const mobileAccordion = document.getElementById("mobileAccordion");
        const desktopAccordion = document.getElementById("rebalanceAccordion");
        
        if (openBtn && popup) {
            openBtn.addEventListener("click", () => {
                if (window.innerWidth < 768) {
                    mobileAccordion.innerHTML = desktopAccordion.innerHTML;
                    popup.style.display = "block";
                }
            });
        }
        
        if (closeBtn && popup) {
            closeBtn.addEventListener("click", () => {
                popup.style.display = "none";
            });
        }
        
        if (popup) {
            popup.addEventListener("click", (e) => {
                if (e.target === popup) {
                    popup.style.display = "none";
                }
            });
        }
    });    
</script>