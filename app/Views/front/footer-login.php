
    <div class="sc-product-offcanvas-area" style="padding:0px; margin:0px;">
        <div class="sc-offcanvas-header d-flex align-items-center justify-content-between">
            <header class="sc-header-section" id="sc-header-sticky">            
                <div class="sc-header-content sc-header-content-two">
                    <div class="container">
                        <div class="row align-items-center justify-content-between p-z-idex">
                            <div class="col-lg-9 col-8">
                                <div class="sc-menu-inner d-flex align-items-center">
                                    <div class="sc-header-logo sc-pr-100  d-flex align-items-center">
                                        <a href="https://valueeducator.com/new/index.php"><img src="<?= base_url($siteSettings['fld_header_logo']) ?>" alt="Logo"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-4">
                                <div class="sc-menu-select-box d-flex align-items-center justify-content-end">                        
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
                <li class="list-gap hash-has-sub"><a href="<?= base_url('investment-philosophy') ?>" class="hash"> Our Investment Philosophy</a></li>
                <li class="list-gap hash-has-sub"><a href="<?= base_url('emerging-titans') ?>" class="hash"> Emerging Titans</a></li>
                <li class="list-gap hash-has-sub"><a href="<?= base_url('tiny-titans') ?>" class="hash"> Tiny Titans</a></li>
            </ul>
        </nav>
    </div>
    
    <script>
        const base_url = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('front/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('front/js/bootstrap.min.js') ?>"></script>

    <script src="<?= base_url('front/js/auth-page.js') ?>"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Override the modal-specific functions to work without a modal
            function showFormById(formId) {
                // Hide all forms
                $('.auth-form').addClass('d-none');
                
                // Show the requested form
                $('#' + formId).removeClass('d-none');
            }
            
            // Handle form switching links
            $('.auth-switch-link').on('click', function(e) {
                e.preventDefault();
                const target = $(this).data('target');
                if (target) {
                    showFormById(target);
                }
            });
            
            // Handle skip profile link
            $('.skip-profile-link').on('click', function(e) {
                e.preventDefault();
                completeSignup();
            });
            
            // Handle skip download link
            $('.skip-download-link').on('click', function(e) {
                e.preventDefault();
                window.location.href = base_url;
            });
        });
    </script>

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
    
    </main>
</body>
</html>