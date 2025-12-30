<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($meta['title']) ?></title>
    <meta name="description" content="<?= esc($meta['description']) ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="apple-touch-icon" href="<?= base_url('front/fav.svg') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('front/fav.svg') ?>">

    <!-- Inline Critical CSS for Above-the-Fold Content -->
    <style>
        body { margin:0; font-family: 'Montserrat', sans-serif; }
        .navbar, .hero { display:flex; align-items:center; justify-content:space-between; }
        .hero h1, .hero p { color:#333; margin:0; }
        /* Add other critical styles for above-the-fold content here */
    </style>

    <!-- Main CSS (synchronous to avoid FOUC) -->
    <link rel="stylesheet" href="<?= base_url('front/css/bootstrap.min.css') ?>">    
    <link rel="stylesheet" href="<?= base_url('front/css/softcoders.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/swiper.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/style-new.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/auth-modal.min.css') ?>">

    <!-- Custom CSS (separate) -->
    <link rel="stylesheet" href="<?= asset_versioned('front/css/custom-media.css') ?>">

    <!-- Google Fonts (preload + swap) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    </noscript>

    <!-- Google tag (gtag.js) -->
    <script>
    (function () {
        let gtmLoaded = false;

        function loadGA() {
            if (gtmLoaded) return;
            gtmLoaded = true;

            // Create script
            var gtagScript = document.createElement('script');
            gtagScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-F6G7FWC4EQ';
            gtagScript.async = true;
            document.head.appendChild(gtagScript);

            // Init GA
            window.dataLayer = window.dataLayer || [];
            function gtag(){ dataLayer.push(arguments); }
            window.gtag = gtag;

            gtag('js', new Date());
            gtag('config', 'G-F6G7FWC4EQ');
        }

        // Load on first interaction
        ['scroll','mousemove','touchstart','keydown'].forEach(event => {
            window.addEventListener(event, loadGA, { once: true });
        });
    })();
    </script>
</head>
<body>
    <header class="sc-header-section" id="sc-header-sticky">
        <div class="sc-header-content sc-header-content-two">
            <div class="container">
                <div class="row align-items-center justify-content-between p-z-idex">
                    <div class="col-lg-9 col-7">
                        <div class="sc-menu-inner d-flex align-items-center">
                            <div class="sc-header-logo sc-pr-100 d-flex align-items-center">
                                <a href="<?= base_url() ?>">
                                    <?php if (!empty($siteSettings['fld_header_logo'])): ?>
                                        <img src="<?= base_url($siteSettings['fld_header_logo']) ?>" alt="Logo" srcset="<?= base_url($siteSettings['fld_header_logo']) ?> 476w, <?= base_url($siteSettings['fld_header_logo']) ?> 240w" sizes="(max-width: 576px) 240px, 476px">
                                    <?php else: ?>
                                        <img src="<?= base_url('front/logo.svg') ?>" alt="Logo">
                                    <?php endif; ?>
                                    <!-- <span class="logo-txt d-lg-block d-md-block d-sm-none">Value<br><span>Educator</span></span> -->
                                </a>
                            </div>
                            <div class="sc-main-menu d-lg-block d-none">
                                <ul class="list-gap main-menu">
                                    <li><a href="<?= base_url() ?>" data-text="Home" class="">Home</a></li>
                                    <li><a href="<?= base_url('about-us') ?>" data-text="About Us" class="">About Us</a></li>
                                    <li><a href="<?= base_url('investment-philosophy') ?>" data-text="Investment Philosophy" class="">Investment Philosophy</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="<?= base_url('emerging-titans') ?>" onclick="return false;">Products</a>
                                        <?php
                                            $dashboardLinks = [];
                                            foreach ($userSubscriptions as $sub) {
                                                if ($sub['product_id'] == 1) {
                                                    $dashboardLinks['emerging-titans'] = base_url('dashboard-emerging-titan');
                                                }
                                                if ($sub['product_id'] == 2) {
                                                    $dashboardLinks['tiny-titans'] = base_url('dashboard-tiny-titan');
                                                }
                                            }
                                        ?>
                                        <ul class="list-gap sub-menu-list">
                                            <li>
                                                <a href="<?= $dashboardLinks['emerging-titans'] ?? base_url('emerging-titans'); ?>"
                                                data-text="Emerging Titans">Emerging Titans</a>
                                            </li>
                                            <li>
                                                <a href="<?= $dashboardLinks['tiny-titans'] ?? base_url('tiny-titans'); ?>"
                                                data-text="Tiny Titans">Tiny Titans</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <!-- User is logged in -->
                        <div class="col-lg-3 col-5">
                            <div class="sc-menu-select-box d-flex align-items-center justify-content-end">
                                <div class="header-btn">
                                    <div class="welc-user d-flex justify-content align-items-center">
                                        <a class="notification" data-target="box1" href="#">
                                            <?php if (!empty(session()->get('userProfileImage'))): ?>
                                                <img src="<?= base_url(session()->get('userProfileImage')) ?>">
                                            <?php else: ?>
                                                <img src="<?= base_url('images/no_image.png') ?>">
                                            <?php endif; ?>
                                        </a>
                                        <b class="d-none d-lg-block">
                                            <?= session()->get('userName') ?><br>
                                            <span><a href="<?= base_url('auth/logout') ?>">Sign Out</a></span>
                                        </b>

                                        <a class="notification" data-target="box2" href="#">
                                            <img src="<?= base_url('images/notifications.png') ?>">
                                            <span class="action">1</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="sc-hambagur-icon d-none">
                                    <a id="canva_expander" href="#" class="nav-menu-link menu-button">
                                        <span class="dot1"></span>
                                        <span class="dot2"></span>
                                        <span class="dot3"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- User is not logged in -->
                        <div class="col-lg-3 col-5">
                            <div class="sc-menu-select-box d-flex align-items-center justify-content-end">
                                <div class="header-btn d-block d-lg-none">
                                    <a data-bs-target="#authModal" data-bs-toggle="modal" href="#" id="accountIcon">
                                        <img class="hover-image" src="<?= base_url('front/account_circle.svg') ?>" width="32" style="width:32px; pointer: cursor;" alt="User Account Icon">
                                    </a>
                                </div>
                                <div class="sc-hambagur-icon d-none sc-ml-20 sc-mt-0">
                                    <a id="canva_expander" href="#" class="nav-menu-link menu-button">
                                        <span class="dot1"></span>
                                        <span class="dot2"></span>
                                        <span class="dot3"></span>
                                    </a>
                                </div>
                                <div class="header-btn d-none d-lg-block">
                                    <a class="sc-primary-btn auth-trigger" data-bs-toggle="modal" data-bs-target="#authModal" href="#">
                                        <img class="hover-image" src="<?= base_url('front/account_circle.svg') ?>" alt="Login Icon"> Login
                                    </a>
                                    <button type="button" class="info" aria-label="More information" aria-describedby="content1" nmouseenter="showDiv('content1')" onmouseleave="hideDiv('content1')" onfocus="showDiv('content1')" onblur="hideDiv('content1')" style="border: 0px; background: none;">
                                        <div class="image"></div>
                                    </button>
                                    <div id="content1" class="hidden-content text-right">
                                        <p>Get access to our free<br>E-book and other resources!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                
                <!-- Product Tabs for Logged-in Users -->
                <?php if (session()->get('isLoggedIn') && isset($allProducts) && !empty($allProducts)): ?>
                <?php 
                    $current_url = current_url();
                    $activeProduct = '';
                    $displayTab = false;
                    
                    if (strpos($current_url, 'emerging-titans') !== false || 
                        strpos($current_url, 'dashboard-emerging-titan') !== false || 
                        strpos($current_url, 'portfolio-emerging-titan') !== false || 
                        strpos($current_url, 'management-interviews-emerging-titan') !== false || 
                        strpos($current_url, 'quarterly-updates-emerging-titan') !== false ||
                        strpos($current_url, 'knowledge-center-emerging-titan') !== false ||
                        strpos($current_url, 'substack-updates') !== false ||
                        strpos($current_url, 'youtube-videos') !== false) {
                        
                        $activeProduct = 'emerging-titans';
                        $displayTab = true;

                    } elseif (strpos($current_url, 'tiny-titans') !== false || 
                            strpos($current_url, 'dashboard-tiny-titan') !== false || 
                            strpos($current_url, 'portfolio-tiny-titan') !== false || 
                            strpos($current_url, 'management-interviews-tiny-titan') !== false || 
                            strpos($current_url, 'knowledge-center-tiny-titan') !== false ||
                            strpos($current_url, 'quarterly-updates-tiny-titan') !== false) {
                        
                        $activeProduct = 'tiny-titans';
                        $displayTab = true;
                    }

                    if($displayTab == true) {
                ?>
                    <div class="row sc-pt-0 sc-md-pt-30 sc-pb-20 sc-md-pb-20">
                        <div class="col-lg-7 col-md-7 m-auto">
                            <ul class="nav nav-pills titan-tabs1 d-flex justify-content-center mb-0" id="titansTab" role="tablist">
                                <?php foreach ($allProducts as $product): ?>

                                    <?php 
                                        // Custom dashboard link logic
                                        if ($product['fld_slug'] == 'emerging-titans') {
                                            $href = base_url('dashboard-emerging-titan');
                                        } elseif ($product['fld_slug'] == 'tiny-titans') {
                                            $href = base_url('dashboard-tiny-titan');
                                        } else {
                                            $href = base_url($product['fld_slug']);
                                        }
                                    ?>

                                    <li class="nav-item" role="presentation">
                                        <a href="<?= $href ?>" 
                                        class="nav-link1 <?= ($product['fld_slug'] == $activeProduct) ? 'active' : '' ?>" 
                                        id="<?= $product['fld_slug'] ?>-tab" 
                                        type="button">
                                            <img src="<?= base_url('images/titan-' . $product['fld_slug'] . '.svg') ?>" width="24"> 
                                            <?= $product['fld_title'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>                                    
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            <?php endif; ?>
                
            </div>
        </div>
    </header>
    <main id="main-content">