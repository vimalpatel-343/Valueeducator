<script>
let razorpayLoaded = false;

function loadRazorpay(callback) {
    if (razorpayLoaded) {
        callback();
        return;
    }

    const script = document.createElement('script');
    script.src = "https://checkout.razorpay.com/v1/checkout.js";
    script.onload = function () {
        razorpayLoaded = true;
        callback();
    };
    document.body.appendChild(script);
}

$(document).ready(function() {

    /* -------------------------------
       BUY NOW BUTTON CLICK HANDLER
    -------------------------------- */
    $('.buy-now-btn').click(function (e) {
        e.preventDefault();

        const btn = this;

        loadRazorpay(function () {
            handleBuyNow(btn);
        });
    });

    function handleBuyNow(btn)
    {
        // Login check
        <?php if (!session()->get('isLoggedIn')): ?>
            $('.modal.show').modal('hide');
            $('#authModal').modal('show');
            return;
        <?php endif; ?>

        const productId    = $(btn).data('product-id');
        const productName  = $(btn).data('product-name');
        const amount       = $(btn).data('amount');
        const subTitle     = $(btn).data('sub-title');
        const expiredMonth = $(btn).data('expired-month');

        $('#modal-amount').text(amount);
        $('#modal-sub-title').text(subTitle);
        $('#button-amount').text(amount);

        $('#payment_product_id').val(productId);
        $('#payment_amount').val(amount);
        $('#payment_product_name').val(productName);
        $('#payment_sub_title').val(subTitle);
        $('#payment_expired_month').val(expiredMonth);

        $('#payment-content').show();
        $('#payment-loader').hide();
        $('#payment-success').hide();
        $('#payment-error').hide();

        $('.modal.show').modal('hide');
        $('#payment-modal').modal('show');
    }

    /* -------------------------------
       PAYMENT FORM SUBMIT HANDLER
    -------------------------------- */
    $('#payment-form').submit(function(e) {
        e.preventDefault();

        const productId   = $('#payment_product_id').val();
        const amount      = $('#payment_amount').val();
        const productName = $('#payment_product_name').val();

        // Show loader
        $('#payment-content').hide();
        $('#payment-loader').show();

        // Create RazorPay order
        $.ajax({
            url: base_url + 'payment/createOrder',
            type: 'POST',
            data: {
                product_id: productId,
                amount: amount,
                subscription_type: 'yearly'
            },
            dataType: 'json',

            success: function(response) {
                if (response.status !== 'success') {
                    showError('Error creating order: ' + response.message);
                    return;
                }

                // Razorpay options
                const options = {
                    key: response.key_id,
                    amount: response.amount,
                    currency: "INR",
                    name: "Value Educator",
                    description: response.description,
                    image: base_url + "images/logo.svg",
                    order_id: response.order_id,

                    handler: function (rzpRes) {
                        verifyPayment(rzpRes, response.payment_id, productId, productName);
                    },

                    modal: {
                        ondismiss: function () {
                            $('#payment-loader').hide();
                            $('#payment-content').show();
                        }
                    },

                    prefill: {
                        name: "<?= session()->get('userName') ?>",
                        email: "<?= session()->get('userEmail') ?>",
                        contact: "<?= session()->get('userMobile') ?>"
                    },

                    notes: {
                        product_id: productId,
                        product_name: productName
                    },

                    theme: {
                        color: "#6c5ce7"
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            },

            error: function () {
                showError("Error processing your request. Please try again.");
            }
        });
    });




    /* -------------------------------
       VERIFY PAYMENT (AFTER SUCCESS)
    -------------------------------- */
    function verifyPayment(rzpRes, paymentId, productId, productName) {
        $.ajax({
            url: base_url + 'payment/verifyPayment',
            type: 'POST',
            data: {
                razorpay_payment_id: rzpRes.razorpay_payment_id,
                razorpay_order_id: rzpRes.razorpay_order_id,
                razorpay_signature: rzpRes.razorpay_signature,
                payment_id: paymentId
            },
            dataType: 'json',

            success: function (verifyRes) {

                if (verifyRes.status === 'success') {
                    $('#payment-loader').hide();
                    $('#payment-success').show();
                    $('#success-product-name').text(productName);

                    let dashboardUrl = base_url;
                    if (productId == 1) dashboardUrl = base_url + 'dashboard-emerging-titan';
                    if (productId == 2) dashboardUrl = base_url + 'dashboard-tiny-titan';

                    $('#go-to-dashboard').attr('href', dashboardUrl);

                } else {
                    showError(verifyRes.message || 'Payment verification failed.');
                }
            },

            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    const err = xhr.responseJSON.error;

                    if (err.reason === 'international_transaction_not_allowed') {
                        showError('International cards are not supported. Please use a domestic test card.');
                    } else {
                        showError(err.description || "Payment verification failed.");
                    }
                } else {
                    showError("Error verifying payment. Please contact support.");
                }
            }
        });
    }




    /* -------------------------------
       SHOW ERROR FUNCTION (Reusable)
    -------------------------------- */
    function showError(msg) {
        $('#payment-loader').hide();
        $('#payment-content').hide();
        $('#payment-error').show();
        $('#error-payment-message').text(msg);
    }




    /* -------------------------------
       COMMON BUTTON HANDLERS
    -------------------------------- */
    $(document).on('click', '#try-again', function () {
        $('#payment-error').hide();
        $('#payment-content').show();
        $('#error-payment-message').text('');
    });

    $(document).on('click', '#go-to-dashboard', function () {
        window.location.href = $(this).attr('href');
    });

    // When Orders link is clicked
    $('a[data-bs-target="#search-modal-orders"]').click(function(e) {
        e.preventDefault();
        
        // Show loading
        $('#order-loading').show();
        $('#order-content').hide();
        $('#no-order-content').hide();
        
        // Show modal
        $('#search-modal-orders').modal('show');
        
        // Fetch orders
        $.ajax({
            url: base_url + 'user-account/getOrders',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#order-loading').hide();
                
                if (response.status === 'success' && response.orders.length > 0) {
                    // Build orders HTML
                    let ordersHtml = '';
                    response.orders.forEach(function(order) {
                        ordersHtml += `
                            <div class="white-box d-lg-flex justify-content-between align-items-center">
                                <div class="container">
                                    <div class="row">
                                        <div class="left-content d-lg-flex d-flex">
                                            <img src="/images/icon-plan.svg" style="width:55px;">
                                            <h2 class="sc-lg-ml-26">
                                                <span class="font-lg-16-bold">${order.product_name}</span>
                                            </h2>
                                        </div>
                                        <div class="col-lg-12">
                                            <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Total Amount</h3>
                                            <p class="font-lg-16-bold sc-mb-20">Rs. ${order.amount} (including 18% GST)</p>
                                        </div>
                                        <div class="col-lg-6 col-6">
                                            <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Purchased on</h3>
                                            <p class="font-lg-16-bold sc-mb-0">${order.created_at}</p>
                                        </div>
                                        <div class="col-lg-6 col-6">
                                            <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Payment</h3>
                                            <p class="font-lg-16-bold sc-mb-0">${order.payment_method || 'RazorPay'}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#order-html .hoz-scroll').html(ordersHtml);
                    $('#order-content').show();
                } else {
                    $('#no-order-content').show();
                }
            },
            error: function() {
                $('#order-loading').hide();
                $('#no-order-content').show();
            }
        });
    });
    
    // When Subscriptions link is clicked
    $('a[data-bs-target="#search-modal-subscription"]').click(function(e) {
        e.preventDefault();
        
        // Show loading
        $('#subscription-loading').show();
        $('#subscription-content').hide();
        $('#no-subscription-content').hide();
        
        // Show modal
        $('#search-modal-subscription').modal('show');
        
        // Fetch subscriptions
        $.ajax({
            url: base_url + 'user-account/getSubscriptions',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#subscription-loading').hide();
                
                if (response.status === 'success' && response.subscriptions.length > 0) {
                    // Build subscriptions HTML
                    let subscriptionsHtml = '';
                    response.subscriptions.forEach(function(subscription) {
                        // Calculate end date formatted
                        let endDate = new Date(subscription.end_date);
                        let formattedEndDate = endDate.toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        });
                        
                        subscriptionsHtml += `
                            <div class="subscription-box green-color d-lg-flex justify-content-between align-items-center sc-md-pl-0 sc-md-pr-0">
                                <div class="container">
                                    <div class="row">
                                        <div class="left-content d-lg-flex d-flex">
                                            <img src="/images/icon-plan.svg" style="width:55px;">
                                            <h2 class="sc-lg-ml-26">
                                                <span class="font-lg-16-bold">${subscription.product_name}</span>
                                            </h2>
                                        </div>
                                        <div class="white-box sc-md-pl-0 sc-md-pr-0">
                                            <div class="container">
                                                <div class="row g-0">
                                                    <div class="col-lg-6 col-6">
                                                        <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Subscribed on</h3>
                                                        <p class="font-lg-16-bold sc-mb-0">${subscription.start_date}</p>
                                                    </div>
                                                    <div class="col-lg-6 col-6">
                                                        <h3 class="font-lg-14-normal sc-mb-0" style="color:#8D8D8D;">Ends on</h3>
                                                        <p class="font-lg-16-bold sc-mb-0">${formattedEndDate}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#subscription-html .hoz-scroll').html(subscriptionsHtml);
                    $('#subscription-content').show();
                } else {
                    $('#no-subscription-content').show();
                }
            },
            error: function() {
                $('#subscription-loading').hide();
                $('#no-subscription-content').show();
            }
        });
    });

});
</script>
<!-- KYC Pending Modal -->
<div class="modal fade" id="kycPendingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">KYC Verification Pending</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center px-4">
                <div class="mb-3">
                    <i class="bx bx-error-circle" style="font-size: 56px; color: #ff5252;"></i>
                </div>

                <h4 class="fw-semibold mb-2">Action Required</h4>

                <p class="text-muted mb-3">
                    Your <strong>KYC (Know Your Customer)</strong> verification is currently pending.  
                    To proceed with subscription purchase, please complete your KYC verification.
                </p>

                <div class="alert alert-light border mt-3 text-start">
                    <p class="mb-2 fw-semibold">Need Assistance?</p>
                    <p class="mb-1 text-muted">
                        Please contact the <strong>Site Administrator</strong> for support regarding KYC verification.
                    </p>
                    <p class="mb-1">
                        <i class="bx bx-envelope"></i>
                        <strong>Email:</strong> <?= $siteSettings['fld_email'] ?>
                    </p>
                    <p class="mb-0">
                        <i class="bx bx-phone"></i>
                        <strong>Phone:</strong> <?php echo $siteSettings['fld_mobile']; ?>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>