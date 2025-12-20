<!-- Payment Modal -->
<div id="payment-modal" class="modal fade search-modal" role="dialog" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" style="max-width:90%;">
        <div class="modal-content">
            <!-- Initial Payment Form -->
            <div id="payment-content">
                <div class="d-flex justify-content-between align-items-top">
                    <h3 class="font-lg-24-bold font-20-bold">Required Details</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background: none;">
                        Close
                        <img src="images/cancel.png">
                    </button>
                </div>
                
                <div class="bdr-radius light-purple-color sc-mt-20 sc-mb-20 sc-pt-10 sc-pb-0 sc-pl-20 sc-pr-20">
                    <h3 class="sc-mb-0 font-lg-36-bold font-36-bold">₹<span id="modal-amount">23999.00</span></h3>
                    <p class="font-lg-18-normal font-18-medium">(<span id="modal-sub-title">12 month subscription</span>)</p>
                </div>
                
                <p class="font-lg-16-normal">As per SEBI regulations, all users are mandated to complete the KYC that is validated for 1 year. Post payment, you will be redirected to the KYC screen</p>
                
                <form id="payment-form">
                    <div class="user_details" style="padding:0px;">
                        <input type="hidden" id="payment_product_id" name="product_id">
                        <input type="hidden" id="payment_amount" name="amount">
                        <input type="hidden" id="payment_product_name" name="product_name">
                        <input type="hidden" id="payment_sub_title" name="sub_title">
                        <input type="hidden" id="payment_expired_month" name="expired_month">
                        
                        <div class="foot-lnk sc-mt-10" id="error-payment-message" style="color:red;"></div>
                        <button type="submit" class="paynow-btn sc-mt-0 text-center w-100" style="font-size:20px;">
                            Pay <i class="fa fa-inr"></i>&nbsp;<span id="button-amount" style="display:inline;"> 23999.00</span>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Payment Loader -->
            <div id="payment-loader" class="text-center py-5" style="display: none;">
                <img src="images/loading.gif" alt="Processing..." style="width:40px;">
                <p class="mt-2 font-lg-14-normal">Processing payment...</p>
            </div>

            <!-- Payment Success -->
            <div id="payment-success" class="hide-content" style="display: none;">
                <div class="text-center">
                    <h3 class="font-lg-24-bold font-16-bold">Payment Successful!</h3>
                    <p class="font-lg-16-normal font-dark-grey">Your subscription to <span id="success-product-name">Emerging Titans</span> is now active. Let's explore the features and get you started.</p>
                    <div style="width:300px; margin:0px auto;">
                        <img src="images/empowering.png">
                    </div>
                </div>

                <button id="go-to-dashboard" class="sc-primary-btn btn-color-1 sc-mt-20 font-lg-20-normal font-16-normal text-center w-100 position-relative">
                    Go to Dashboard
                </button>
            </div>
            
            <!-- Payment Error -->
            <div id="payment-error" class="hide-content" style="display: none;">
                <div class="text-center">
                    <h3 class="font-lg-24-bold font-16-bold">Payment Failed!</h3>
                    <p class="font-lg-16-normal font-dark-grey">We're sorry, but there was an issue processing your payment. Please try again or contact support if the problem persists.</p>
                    <div style="width:300px; margin:0px auto;">
                        <img src="images/payment-failed.png">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button id="try-again" class="sc-primary-btn btn-color-3 sc-mt-20 font-lg-20-normal font-16-normal text-center w-50 position-relative">
                        Try Again
                    </button>
                    <button id="cancel-payment" class="sc-primary-btn btn-dark-grey sc-mt-20 font-lg-20-normal font-16-normal text-center w-50 position-relative" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders Modal -->
<div id="search-modal-orders" class="modal fade search-modal w-60" role="dialog" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="order-loading" class="text-center py-5" style="display: none;">
                <img src="images/loading.gif" alt="Loading..." style="width:40px;">
                <p class="mt-2 font-lg-14-normal">Fetching your orders...</p>
            </div>		
            
            <div id="no-order-content" style="display:none;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="font-lg-24-bold font-16-bold">Orders</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background: none;">
                        Close
                        <img src="images/cancel.png">
                    </button>
                </div>
                <div class="subscription-box dark-gray">
                    <img src="images/order.svg">
                    <p class="font-lg-16-bold sc-mt-20 sc-mb-10">No Order History</p>
                    <p class="font-lg-14-normal sc-mt-10">Orders for your invested products appear here. Start discovering our products</p>
                </div>
            </div>
            
            <div id="order-content" style="display: none;">
                <div id="order-html">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="font-lg-24-bold font-16-bold">Orders</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background: none;">
                            Close
                            <img src="images/cancel.png">
                        </button>
                    </div>
                    <div class="hoz-scroll">
                        <!-- Orders will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Subscriptions Modal -->
<div id="search-modal-subscription" class="modal fade search-modal w-60" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="subscription-loading" class="text-center py-5" style="display: none;">
                <img src="images/loading.gif" alt="Loading..." style="width:40px;">
                <p class="mt-2 font-lg-14-normal">Fetching your subscription...</p>
            </div>	
            
            <div id="no-subscription-content" style="display:none">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="font-lg-24-bold font-16-bold">Subscriptions</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background: none;">
                        Close
                        <img src="images/cancel.png">
                    </button>
                </div>
                
                <div class="subscription-box dark-gray">
                    <img src="images/subscription.svg">
                    <p class="font-lg-16-bold sc-mt-20 sc-mb-10">No Subscriptions</p>
                    <p class="font-lg-14-normal sc-mt-10"><a href="#" class="">Subscribe to our products and manage it here</a></p>
                </div>
            </div>
            
            <div id="subscription-content" class="hide-content" style="display: none;">
                <div id="subscription-html">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="font-lg-24-bold font-16-bold">Subscriptions</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background: none;">
                            Close
                            <img src="images/cancel.png">
                        </button>
                    </div>
                    <div class="hoz-scroll">
                        <!-- Subscriptions will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* .modal-dialog {
    max-width: 60%;
} */

.hoz-scroll {
    overflow-x: auto;
}

.white-box {
    background-color: #fff;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.subscription-box {
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    margin-bottom: 20px;
}

.subscription-box.dark-gray {
    background-color: #f8f9fa;
}

.subscription-box.green-color {
    background-color: #e8f5e9;
}

.subscription-box img {
    width: 60px;
    height: 60px;
    margin-bottom: 15px;
}

.left-content img {
    margin-right: 15px;
}

.sc-lg-ml-26 {
    margin-left: 26px;
}

.status--green {
    color: #28a745;
}

.less-pad {
    padding: 5px 15px;
}
</style>