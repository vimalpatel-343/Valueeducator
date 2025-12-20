    <?php
        // Initialize variables
        $dashboard_link = '';
        $portfolio_link = '';
        $knowledge_link = '';
        $dashboard_active = '';
        $portfolio_active = '';
        $knowledge_active = '';

        // Get current URL
        $current_url = current_url();

        // Check if user is logged in
        if (session()->get('isLoggedIn')) {
            
            // Determine which product is active based on URL
            if (strpos($current_url, 'emerging-titans') !== false || strpos($current_url, 'dashboard-emerging-titan') !== false || strpos($current_url, 'portfolio-emerging-titan') !== false) {
                // For Emerging Titans
                $dashboard_link = base_url('dashboard-emerging-titan');
                $portfolio_link = base_url('portfolio-emerging-titan');
                $knowledge_link = base_url('knowledge-center');
            } elseif (strpos($current_url, 'tiny-titans') !== false || strpos($current_url, 'dashboard-tiny-titan') !== false || strpos($current_url, 'portfolio-tiny-titan') !== false) {
                // For Tiny Titans
                $dashboard_link = base_url('dashboard-tiny-titan');
                $portfolio_link = base_url('portfolio-tiny-titan');
                $knowledge_link = base_url('knowledge-center');
            } else {
                // Default to Emerging Titans if not on a product page
                $dashboard_link = base_url('dashboard-emerging-titan');
                $portfolio_link = base_url('portfolio-emerging-titan');
                $knowledge_link = base_url('knowledge-center');
            }
            
            // Determine which footer item should be active based on current page
            $dashboard_active = (strpos($current_url, 'dashboard') !== false) ? 'active' : '';
            $portfolio_active = (strpos($current_url, 'portfolio') !== false) ? 'active' : '';
            $knowledge_active = (strpos($current_url, 'knowledge-center') !== false) ? 'active' : '';
        }
    ?>

    <div class="floating-div w-60-percent gray-bg-color d-lg-flex">
        <?php if (session()->get('isLoggedIn')): ?>
            <!-- User is logged in - show Dashboard, Portfolio, Knowledge Centre -->
            <div><a class="sc-primary-btn btn-color-white <?php echo $dashboard_active; ?>" href="<?php echo $dashboard_link; ?>"><img src="<?php echo base_url('images/icon-dashboard.png'); ?>"> Dashboard</a></div>
            <div><a class="sc-primary-btn btn-color-white <?php echo $portfolio_active; ?>" href="<?php echo $portfolio_link; ?>"><img src="<?php echo base_url('images/icon-watchlist.png'); ?>"> Portfolio</a></div>
            <div><a class="sc-primary-btn btn-color-white <?php echo $knowledge_active; ?>" href="<?php echo $knowledge_link; ?>"><img src="<?php echo base_url('images/knowledge.png'); ?>"> Knowledge Centre</a></div>
        <?php else: ?>
            <!-- User is not logged in - show Product Offerings, Call, Chat -->
            <div><a class="sc-primary-btn btn-color-1" data-bs-target="#titan-modal" data-bs-toggle="modal" href="#">Product Offerings</a></div>
            <div><a class="sc-primary-btn btn-color-2" href="tel:<?php echo $siteSettings['fld_mobile']; ?>"><img src="<?php echo base_url('front/icon-call.svg'); ?>"> <span>Call Our Experts</span></a><p>Call Us</p></div>
            <div><a class="sc-primary-btn btn-color-2" href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $siteSettings['fld_mobile']); ?>?text=Hello%20I%20am%20interested%20in%20your%20services" target="_blank"><img src="<?php echo base_url('front/icon-chat.svg'); ?>"> <span>Chat With Us</span></a><p>Chat</p></div>
        <?php endif; ?>
    </div>

    <?php if (session()->get('isLoggedIn')): ?>
        <!-- Mobile footer for logged in users -->
        <div id="bottom-fixed">
            <div class="footer-icon">
                <a href="<?php echo $dashboard_link; ?>" class="<?php echo $dashboard_active; ?>">
                    <p class="circle btn-color-grey"><img src="<?php echo base_url('images/icon-dashboard.png'); ?>"></p>
                    <span class="label">Dashboard</span>
                </a>
            </div>
            <div class="footer-icon">
                <a href="<?php echo $portfolio_link; ?>" class="<?php echo $portfolio_active; ?>">
                    <p class="circle"><img src="<?php echo base_url('images/icon-watchlist.png'); ?>"></p>
                    <span class="label">Portfolio</span>
                </a>
            </div>
            <div class="footer-icon long">
                <a href="<?php echo $knowledge_link; ?>" class="<?php echo $knowledge_active; ?>">
                    <p class="circle"><img src="<?php echo base_url('images/knowledge.png'); ?>"></p>
                    <span class="label">Knowledge Center</span>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <section class="sc-footer-section gray-bg-color sc-footer-style2 sc-pt-40 sc-md-pt-20">
        <div class="container">
            <div class="row sc-pt-40 sc-pb-20 sc-md-pb-30">
                <div class="col-xl-3 col-md-6 col-sm-12 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                    <div class="sc-header-logo- sc-pr-100 d-flex align-items-center d-block d-md-none">
                        <a href="<?= base_url() ?>">
                            <?php if (!empty($siteSettings['fld_footer_logo'])): ?>
                                <img src="<?= base_url($siteSettings['fld_footer_logo']) ?>" alt="Logo">
                            <?php else: ?>
                                <img src="<?= base_url('front/logo.svg') ?>" alt="Logo">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="text-left d-none d-md-inline-block">
                        <div class="footer-logo">
                            <?php if (!empty($siteSettings['fld_footer_logo'])): ?>
                                <img src="<?= base_url($siteSettings['fld_footer_logo']) ?>" alt="Logo"><br>
                            <?php else: ?>
                                <img src="<?= base_url('front/logo.svg') ?>" alt="Logo"><br>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-xl-8 col-md-6 col-sm-12 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="500">
                            <div class="footer-menu-area sc-footer-user sc-md-mb-40">
                                <h4 class="footer-title sc-md-mb-15 font-lg-24-bold font-20-bold">Useful Links</h4>
                                <ul class="footer-menu-list">
                                    <li><a href="<?= base_url() ?>">Home</a></li>
                                    <li><a href="<?= base_url('about-us') ?>">About Us</a></li>
                                    <li><a href="<?= base_url('investment-philosophy') ?>">Investment Philosophy</a></li>
                                    <li><a href="<?= base_url('product-faqs') ?>">Product FAQs</a></li>
                                    <li><a href="<?= base_url('upi-id') ?>">UPI ID</a></li>
                                    <li><a href="<?= base_url('emerging-titans') ?>">Emerging Titans</a></li>
                                    <li><a href="<?= base_url('tiny-titans') ?>">Tiny Titans</a></li>
                                </ul>
                                <ul class="footer-menu-list">
                                    <li><a href="<?= base_url('complaint-data') ?>">Complaint Data</a></li>
                                    <li><a href="<?= base_url('disclosures-and-disclaimer') ?>">Disclosures and Disclaimer</a></li>
                                    <li><a href="<?= base_url('grievance-redressal-escalation-matrix') ?>">Grievance Redressal / Escalation Matrix</a></li>
                                    <li><a href="<?= base_url('investor-charter') ?>">Investor Charter</a></li>
                                    <li><a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a></li>
                                    <li><a href="<?= base_url('refund-and-cancellation') ?>">Refund and Cancellation</a></li>
                                    <li><a href="<?= base_url('terms-and-conditions') ?>">Terms and Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-12 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                            <div class="footer-about sc-md-mt-20 sc-sm-pt-10">
                                <h4 class="footer-title sc-md-mb-15 font-lg-24-bold font-20-bold">Contact</h4>
                                <p class="footer-des font-lg-16-normal font-14-normal"><?= $siteSettings['fld_full_address'] ?></p>
                                <div class="sc-contact-number d-flex align-items-center sc-mb-5">
                                    <div class="phone-icon">
                                        <img src="<?= base_url('front/icon-map.svg') ?>">
                                    </div>
                                    <div class="contact-number">
                                        <a href="#" class="number">Google Map Location</a>
                                    </div>
                                </div>
                                <div class="sc-contact-number d-flex align-items-center sc-mb-5">
                                    <div class="phone-icon">
                                        <img src="<?= base_url('front/icon-envelope.svg') ?>">
                                    </div>
                                    <div class="contact-number">
                                        <a href="mailto:<?= $siteSettings['fld_email'] ?>" class="number"><?= $siteSettings['fld_email'] ?></a>
                                    </div>
                                </div>
                                <div class="sc-contact-number d-flex align-items-center sc-mb-5">
                                    <div class="phone-icon">
                                        <img src="<?= base_url('front/icon-phone.svg') ?>">
                                    </div>
                                    <div class="contact-number">
                                        <a href="tel:<?= $siteSettings['fld_mobile'] ?>" class="number ph"><?= $siteSettings['fld_mobile'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                            <div class="copyright-area border-0">
                                <div class="copyright-text sc-pt-10 sc-pb-100 sc-md-pb-80 sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                                    <p class="font-lg-24-bold font-16-normal">Have an query? Write down to us <a href="mailto:<?= $siteSettings['fld_email'] ?>" class="font-lg-24-bold font-16-bold"><?= $siteSettings['fld_email'] ?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="sc-product-offcanvas-area" style="padding:0px; margin:0px;">
        <div class="sc-offcanvas-header d-flex align-items-center justify-content-between">
            <header class="sc-header-section" id="sc-header-sticky">            
                <div class="sc-header-content sc-header-content-two">
                    <div class="container">
                        <div class="row align-items-center justify-content-between p-z-idex">
                            <div class="col-lg-9 col-8">
                                <div class="sc-menu-inner d-flex align-items-center">
                                    <div class="sc-header-logo sc-pr-100  d-flex align-items-center">
                                        <a href="https://valueeducator.com/new/index.php"><img src="https://valueeducator.com/new/images/home/logo.svg"> <span class="logo-txt">Value<br><span>Educator</span></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-4">
                                <div class="sc-menu-select-box d-flex align-items-center justify-content-end">                        
                                    <div class="header-btn d-block d-lg-none">                                
                                        <img class="hover-image" src="https://valueeducator.com/new/images/home/account_circle.svg" width="32" style="width:32px;">
                                    </div>
                                    <div class="offcanvas-icon sc-ml-20 sc-mr-0 sc-mt-10">            
                                        <a id="canva_close" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="25px" height="25px">
                                                <path d="M 9.15625 6.3125 L 6.3125 9.15625 L 22.15625 25 L 6.21875 40.96875 L 9.03125 43.78125 L 25 27.84375 L 40.9375 43.78125 L 43.78125 40.9375 L 27.84375 25 L 43.6875 9.15625 L 40.84375 6.3125 L 25 22.15625 Z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <!-- Canvas Mobile Menu start -->
        <nav class="right_menu_togle mobile-navbar-menu" id="mobile-navbar-menu">
            <ul class="nav-menu sc-mt-100 sc-pl-0">
                <li class="list-gap hash-has-sub"><a href="<?= base_url() ?>" class="hash"> Home</a></li>	
                <li class="list-gap hash-has-sub"><a href="<?= base_url('about-us') ?>" class="hash"> About Us</a></li>
                <li class="list-gap hash-has-sub"><a href="<?= base_url('investment-philosophy') ?>" class="hash"> Investment Philosophy</a></li>
                <li class="list-gap hash-has-sub"><a href="<?= base_url('emerging-titans') ?>" class="hash"> Emerging Titans</a></li>
                <li class="list-gap hash-has-sub"><a href="<?= base_url('tiny-titans') ?>" class="hash"> Tiny Titans</a></li>
            </ul>
        </nav>
    </div>

    <div id="scrollUp">
        <i class="fa fa-angle-right"></i>
    </div>

    <div class="boxfin-scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
        <div class="boxfin-scroll-top-icon">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" viewBox="0 0 24 24" data-icon="mdi:arrow-up" class="iconify iconify--mdi">
                <path fill="currentColor" d="M13 20h-2V8l-5.5 5.5l-1.42-1.42L12 4.16l7.92 7.92l-1.42 1.42L13 8v12Z"></path>
            </svg>
        </div>
    </div>

    <?= $this->include('front/loginmodal') ?>

    <!-- Box 2 -->
    <div class="box p-0" id="box2" style="display: none;">
        <div class="p-3">
            <h3 class="font-lg-16-bold">Welcome to Value Educator</h3>
            <p class="font-lg-14-normal">Download your exclusive guide and explore insights to elevate your investment strategy.</p>
            <p class="font-lg-16-bold sc-mb-0">
                <a target="_blank" href="<?= $siteSettings['fld_ebook'] ?>" class="font-purple" id="downloadEbookLink">Download E-book</a>
            </p>
        </div>
    </div>

    <!-- Add this where you want the profile box to appear -->
    <div class="box" id="box1" style="display: none;">
        <div class="welc-user d-flex justify-content align-items-center">
            <img src="<?= !empty(session()->get('userProfileImage')) ? base_url(session()->get('userProfileImage')) : 'images/no_image.png' ?>" style="width:60px;height:60px;">
            <h2 class="d-lg-block">
                <?= session()->get('userName') ?><br>
                <span><a href=""><?= session()->get('userEmail') ?></a></span><br>
                <span><a href=""><?= session()->get('userMobile') ?></a></span>
            </h2>						  
        </div>

        <a class="sc-primary-btn text-center btn-color-white w-100 font-18-medium sc-mt-5 sc-mb-5" data-bs-target="#search-modal-4" data-bs-toggle="modal" href="#">Edit Profile</a>

        <?php if (!empty($userSubscriptions)): ?>
            <?php foreach ($userSubscriptions as $subscription): ?>
                <div class="setting-link-box light-green sc-mt-5 sc-mb-5 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column flex-sm-row">
                        <span class="fixed-span font-lg-14-normal"><?= $subscription['product_name'] ?></span>
                        <span class="font-lg-16-bold status--green ms-sm-5">
                            <?php 
                                $endDate = new \DateTime($subscription['end_date']);
                                $currentDate = new \DateTime();
                                $interval = $currentDate->diff($endDate);
                                $daysLeft = $interval->days;
                                echo $daysLeft . ' days left';
                            ?>
                        </span>
                    </div>
                    <a class="sc-primary-btn less-pad btn-color-5 font-lg-16-bold" href="#">Renew</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <p class="font-lg-14-normal sc-mt-5 sc-mb-5">Activity</p>

        <div class="setting-link-box sc-mb-5">
            <ul class="sidebar-info">
                <li>
                    <a data-bs-target="#search-modal-orders" data-bs-toggle="modal" href="#"><img src="images/cart.svg"> Orders <span><i class="fa fa-angle-right"></i></span></a>
                </li>
                <li>
                    <a data-bs-target="#search-modal-subscription" data-bs-toggle="modal" href="#"><img src="images/payment.svg"> Subscription <span><i class="fa fa-angle-right"></i></span></a>
                </li>
            </ul>
        </div>

        <div class="setting-link-box sc-mb-5">
            <ul class="sidebar-info">
                <li>
                    <a href="#"><img src="images/share.svg"> Share with friends <span><i class="fa fa-angle-right"></i></span></a>
                </li>
            </ul>
        </div>

        <p class="font-lg-14-normal  sc-mt-5 sc-mb-5">Useful links</p>

        <div class="setting-link-box">
            <ul class="sidebar-info">
                <li><a href="<?= base_url('about-us') ?>"> About Us</a></li>
                <li><a href="<?= base_url('investment-philosophy') ?>"> Investment Philosophy</a></li>
                <li><a href="<?= base_url('product-faqs') ?>"> Product FAQs</a></li>
            </ul>
        </div>
        <br>
        <a href="<?= base_url('auth/logout') ?>" class="logout"><img src="images/logout.svg"> Logout</a>
        <br>
    </div>

    
    <?= $this->include('front/modals/product_comparison_modal') ?>

    <script>
        const base_url = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('front/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('front/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('front/js/auth-modal.js') ?>"></script>

    <?php
        if (
            strpos($current_url, 'portfolio-tiny-titan') !== false ||
            strpos($current_url, 'portfolio-emerging-titan') !== false ||
            strpos($current_url, 'dashboard-emerging-titan') !== false ||
            strpos($current_url, 'dashboard-tiny-titan') !== false
        ) {
    ?>
        <script src="<?= base_url('assets/js/pdf-viewer.js') ?>"></script>
        <script src="<?= base_url('assets/js/scuttlebutt.js') ?>"></script>
        <script src="<?= base_url('assets/js/stockupdate.js') ?>"></script>
        <link rel="stylesheet" href="<?= base_url('assets/css/pdf-viewer.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/updatemodal.css') ?>">
    <?php } ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- KYC Modal -->
    <div class="modal fade" id="kycModal" tabindex="-1" aria-labelledby="kycModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="kycModalLabel">KYC Verification Required</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-user-check fa-4x text-warning"></i>
                    </div>
                    <h4 class="mb-3">Complete Your KYC Verification</h4>
                    <p class="text-muted">
                        You have an active subscription but KYC verification is required to access this content.
                        Please complete your KYC to continue accessing all premium features.
                    </p>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        KYC verification is a one-time process and helps us comply with regulatory requirements.
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Maybe Later</button>
                    <a href="https://kyc-third-party-site.com" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt me-2"></i>Complete KYC Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($showKycModal)): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show KYC modal when page loads
        var kycModal = new bootstrap.Modal(document.getElementById('kycModal'));
        kycModal.show();
        
        // Prevent closing modal by clicking outside
        document.getElementById('kycModal').addEventListener('click', function(e) {
            if (e.target === this) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });
    </script>
    <?php endif; ?>

    <script>
        function formatCountry(option) {
            if (!option.id) return option.text;
            var flagUrl = $(option.element).data('flag');
            if(!flagUrl) return option.text;
            return $('<span><img src="' + flagUrl + '" style="width:20px; margin-right:8px; vertical-align:middle;">' + option.text + '</span>');
        }

        $(document).ready(function() {
            $('#countryCode').select2({
                templateResult: formatCountry,
                templateSelection: formatCountry,
                minimumResultsForSearch: 5,
                width: '100%',
                dropdownAutoWidth: true
            });

            // Add Bootstrap form-control class to Select2 container
            $('#countryCode').on('select2:open', function() {
                $('.select2-container--open .select2-search__field').addClass('form-control');
            });

            // Make the Select2 input match Bootstrap height
            $('.select2-selection').css({
                'height': 'calc(1.5em + .75rem + 2px)',
                'padding': '.375rem .75rem',
                'font-size': '.875rem',
                'border-radius': '.375rem',
                'border': '1px solid #ced4da'
            });
        });
        </script>

        <style>
        /* Ensure the Select2 box inside input-group aligns with input height */
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: .875rem;
            border-radius: .375rem;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            top: 0;
        }
    </style>
    <script>
        function showDiv(divId) {
            const element = document.getElementById(divId);
            if (element) {
                element.style.display = 'block';
            }
        }

        function hideDiv(divId) {
            const element = document.getElementById(divId);
            if (element) {
                element.style.display = 'none';
            }
        }

        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <script>
        let lastScrollTop = 0;
        $(window).on("scroll", function () {
            const scrollTop = $(this).scrollTop();
            const header = $("#sc-header-sticky");

            if (scrollTop > lastScrollTop) {
                header.css("top", "-150px");
            } else {
                header.css("top", "0");
            }

            lastScrollTop = scrollTop;
        });

        $(document).ready(function() {
            $(".notification").on("click", function(e) {
                e.preventDefault();
                var boxId = $(this).data("target");
                var $box = $("#" + boxId);

                // Toggle this box
                $box.toggle();

                // Optional: Close other boxes
                $(".box").not($box).hide();
            });

            $(document).on("click", function(e) {
                // If click is NOT on box or notification
                if (!$(e.target).closest(".box, .notification").length) {
                    $(".box").hide(); // hide all boxes
                }
            });

            $('#scrollUp').click(function () {
                $('html, body').animate(
                    { scrollTop: 0 },
                    800   // duration in ms (increase for slower scroll)
                );
                return false;
            });

            // OPEN mobile menu
            $('.sc-hambagur-icon').on('click', function (e) {
                e.preventDefault();
                $('.sc-product-offcanvas-area').addClass('active');
                $('body').addClass('offcanvas-open'); // optional
            });

            // CLOSE mobile menu
            $('#canva_close').on('click', function (e) {
                e.preventDefault();
                $('.sc-product-offcanvas-area').removeClass('active');
                $('body').removeClass('offcanvas-open'); // optional
            });

            // OPTIONAL: Close when clicking outside menu
            $(document).on('click', function (e) {
                if (
                    $('.sc-product-offcanvas-area').hasClass('active') &&
                    !$(e.target).closest('.sc-product-offcanvas-area, .sc-hambagur-icon').length
                ) {
                    $('.sc-product-offcanvas-area').removeClass('active');
                    $('body').removeClass('offcanvas-open');
                }
            });
        });

    </script>

    <?= $this->include('front/payment/paymentmodal.php') ?>
    <?= $this->include('front/payment/razorpay.php') ?>

</body>
</html>