<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Front\Home::index');

// Dynamic content pages
$routes->get('content/(:any)', 'Front\Content::index/$1');

// Specific page routes for backward compatibility
$routes->get('investor-charter', 'Front\Content::investorCharter');
$routes->get('about-us', 'Front\Content::aboutUs');
$routes->get('investment-philosophy', 'Front\InvestmentPhilosophyController::index');
$routes->get('disclosures-and-disclaimer', 'Front\Content::index/disclosure');
$routes->get('grievance-redressal-escalation-matrix', 'Front\Content::index/grievance');
$routes->get('privacy-policy', 'Front\Content::index/privacy_policy');
$routes->get('terms-and-conditions', 'Front\Content::index/terms_conditions');
$routes->get('refund-and-cancellation', 'Front\Content::index/refund_cancellation');
$routes->get('complaint-data', 'Front\Content::index/complaint_data');
$routes->get('product-faqs', 'Front\Content::productFAQs');
$routes->get('upi-id', 'Front\Content::index/otp_page');

// Product pages
$routes->get('emerging-titans', 'Front\Product::index/emerging-titans');
$routes->get('tiny-titans', 'Front\Product::index/tiny-titans');

// Dashboard pages
$routes->get('dashboard-emerging-titan', 'Front\Dashboard::emergingTitan');
$routes->get('dashboard-tiny-titan', 'Front\Dashboard::tinyTitan');

// Portfolio pages
$routes->get('portfolio-emerging-titan', 'Front\Dashboard::portfolioEmergingTitan');
$routes->get('portfolio-tiny-titan', 'Front\Dashboard::portfolioTinyTitan');

// Management Interviews pages
$routes->get('management-interviews-emerging-titan', 'Front\Dashboard::managementInterviewsEmergingTitan');
$routes->get('management-interviews-tiny-titan', 'Front\Dashboard::managementInterviewsTinyTitan');

// Quarterly Updates pages
$routes->get('quarterly-updates-emerging-titan', 'Front\Dashboard::quarterlyUpdatesEmergingTitan');
$routes->get('quarterly-updates-tiny-titan', 'Front\Dashboard::quarterlyUpdatesTinyTitan');

// YouTube Videos page
$routes->get('youtube-videos', 'Front\Dashboard::youtubeVideos');

// Substack Updates page
$routes->get('substack-updates', 'Front\Dashboard::substackUpdates');

// Scuttlebutt Notes route
$routes->get('get-scuttlebutt-notes/(:num)', 'Front\Dashboard::getScuttlebuttNotes/$1');

// Stock Updates route
$routes->get('get-stock-updates/(:num)/(:num)', 'Front\Dashboard::getStockUpdates/$1/$2');

// Knowledge Centre routes
$routes->get('knowledge-center', 'Front\Knowledge::index');
$routes->get('knowledge-center/(:any)', 'Front\Knowledge::category/$1');

// Front Auth Routes
$routes->post('auth/send-signup-otp', 'Front\Auth::sendSignupOTP');
$routes->post('auth/verify-signup-otp', 'Front\Auth::verifySignupOTP');
$routes->post('auth/save-profile', 'Front\Auth::saveProfile');
$routes->post('auth/upload-profile-picture', 'Front\Auth::uploadProfilePicture');
$routes->post('auth/complete-signup', 'Front\Auth::completeSignup');
$routes->post('auth/send-login-otp', 'Front\Auth::sendLoginOTP');
$routes->post('auth/verify-login-otp', 'Front\Auth::verifyLoginOTP');
$routes->get('auth/logout', 'Front\Auth::logout');
$routes->get('download-ebook', 'Front\Download::ebook');
$routes->post('track/ebook-download', 'Front\Track::ebookDownload');
   
// Add these payment routes
$routes->get('payment/success', 'Front\Payment::success');
$routes->get('payment/failed', 'Front\Payment::failed');
$routes->post('payment/createOrder', 'Front\Payment::createOrder');
$routes->post('payment/verifyPayment', 'Front\Payment::verifyPayment');

// User Account routes
$routes->post('user-account/getOrders', 'Front\UserAccount::getOrders');
$routes->post('user-account/getSubscriptions', 'Front\UserAccount::getSubscriptions');
$routes->get('user/checkKycStatus', 'Front\UserAccount::checkKycStatus');

// Add these routes
 $routes->get('/auth', 'Auth::index');
 $routes->post('/auth/login', 'Auth::login');
 $routes->get('/logout', 'Auth::logout');

// Admin routes (protected by authentication filter)
$routes->group('/admin', ['filter' => 'adminauth'], function($routes) {
   $routes->get('/', 'Admin\Dashboard::index');
   $routes->get('dashboard', 'Admin\Dashboard::index');
   
   // Investment Philosophy routes
   $routes->get('investment-philosophy', 'Admin\InvestmentPhilosophy::index');
   $routes->get('investment-philosophy/create', 'Admin\InvestmentPhilosophy::create');
   $routes->post('investment-philosophy/store', 'Admin\InvestmentPhilosophy::store');
   $routes->get('investment-philosophy/edit/(:num)', 'Admin\InvestmentPhilosophy::edit/$1');
   $routes->post('investment-philosophy/update/(:num)', 'Admin\InvestmentPhilosophy::update/$1');
   $routes->get('investment-philosophy/delete/(:num)', 'Admin\InvestmentPhilosophy::delete/$1');
   $routes->get('admin/investment-philosophy/delete-image/(:num)/(:num)', 'Admin\InvestmentPhilosophy::deleteImage/$1/$2');

   // FAQ routes
   $routes->get('faqs', 'Admin\FAQ::index');
   $routes->get('faqs/create', 'Admin\FAQ::create');
   $routes->post('faqs/store', 'Admin\FAQ::store');
   $routes->get('faqs/edit/(:num)', 'Admin\FAQ::edit/$1');
   $routes->post('faqs/update/(:num)', 'Admin\FAQ::update/$1');
   $routes->get('faqs/delete/(:num)', 'Admin\FAQ::delete/$1');

   // YouTube Video routes
   $routes->get('youtube-videos', 'Admin\YoutubeVideo::index');
   $routes->get('youtube-videos/create', 'Admin\YoutubeVideo::create');
   $routes->post('youtube-videos/store', 'Admin\YoutubeVideo::store');
   $routes->get('youtube-videos/edit/(:num)', 'Admin\YoutubeVideo::edit/$1');
   $routes->post('youtube-videos/update/(:num)', 'Admin\YoutubeVideo::update/$1');
   $routes->post('youtube-videos/delete/(:num)', 'Admin\YoutubeVideo::delete/$1');
   $routes->get('youtube-videos/refresh/(:num)', 'Admin\YoutubeVideo::refresh/$1');
   
   // Site Settings routes
   $routes->get('settings', 'Admin\SiteSettings::index');
   $routes->post('settings/update', 'Admin\SiteSettings::update');

   // Complaint Data routes
   // $routes->get('complaint-data', 'Admin\ComplaintData::index');
   // $routes->get('complaint-data/create', 'Admin\ComplaintData::create');
   // $routes->post('complaint-data/store', 'Admin\ComplaintData::store');
   // $routes->get('complaint-data/edit/(:num)', 'Admin\ComplaintData::edit/$1');
   // $routes->post('complaint-data/update/(:num)', 'Admin\ComplaintData::update/$1');
   // $routes->get('complaint-data/delete/(:num)', 'Admin\ComplaintData::delete/$1');
   $routes->get('complaint-data', 'Admin\ComplaintData::index');
   $routes->post('complaint-data/update', 'Admin\ComplaintData::update');

   // Disclosures routes
   $routes->get('disclosures', 'Admin\Disclosures::index');
   $routes->post('disclosures/update', 'Admin\Disclosures::update');

   // Grievance Redressal routes
   $routes->get('grievance', 'Admin\GrievanceRedressal::index');
   $routes->post('grievance/update', 'Admin\GrievanceRedressal::update');

   // Investor Charter routes
   $routes->get('investor-charter', 'Admin\InvestorCharter::index');
   $routes->post('investor-charter/update', 'Admin\InvestorCharter::update');

   // Privacy Policy routes
   $routes->get('privacy-policy', 'Admin\PrivacyPolicy::index');
   $routes->post('privacy-policy/update', 'Admin\PrivacyPolicy::update');

   // Terms and Conditions routes
   $routes->get('terms-conditions', 'Admin\TermsConditions::index');
   $routes->post('terms-conditions/update', 'Admin\TermsConditions::update');

   // Refund and Cancellation routes
   $routes->get('refund-cancellation', 'Admin\RefundCancellation::index');
   $routes->post('refund-cancellation/update', 'Admin\RefundCancellation::update');

   // OTP Page routes
   $routes->get('upi-id', 'Admin\OtpPage::index');
   $routes->post('upi-id/update', 'Admin\OtpPage::update');

   // Admin User Management routes
   $routes->get('admin-users', 'Admin\AdminUserManagement::index');
   $routes->get('admin-users/create', 'Admin\AdminUserManagement::create');
   $routes->post('admin-users/store', 'Admin\AdminUserManagement::store');
   $routes->get('admin-users/edit/(:num)', 'Admin\AdminUserManagement::edit/$1');
   $routes->post('admin-users/update/(:num)', 'Admin\AdminUserManagement::update/$1');
   $routes->get('admin-users/delete/(:num)', 'Admin\AdminUserManagement::delete/$1');

   // User Management routes (updated)
   $routes->get('users', 'Admin\UserManagement::index');
   $routes->get('users/create', 'Admin\UserManagement::create');
   $routes->post('users/store', 'Admin\UserManagement::store');
   $routes->get('users/edit/(:num)', 'Admin\UserManagement::edit/$1');
   $routes->post('users/update/(:num)', 'Admin\UserManagement::update/$1');
   $routes->get('users/delete/(:num)', 'Admin\UserManagement::delete/$1');
   $routes->get('users/view-subscriptions/(:num)', 'Admin\UserManagement::viewSubscriptions/$1');
   $routes->get('users/get-login-history/(:num)', 'Admin\UserManagement::getLoginHistory/$1');    
   $routes->post('users/update-kyc-status', 'Admin\UserManagement::updateKycStatus');
   $routes->post('users/updateKycStatus', 'Admin\UserManagement::updateKycStatus');
   $routes->post('users/addSubscription', 'Admin\UserManagement::addSubscription');
   $routes->post('users/updateSubscription', 'Admin\UserManagement::updateSubscription');
   $routes->get('users/getProductPrice/(:num)', 'Admin\UserManagement::getProductPrice/$1');

   // Product Management Routes
   $routes->get('products', 'Admin\Products::index');
   $routes->get('products/create', 'Admin\Products::create');
   $routes->post('products/store', 'Admin\Products::store');
   $routes->get('products/edit/(:num)', 'Admin\Products::edit/$1');
   $routes->post('products/update/(:num)', 'Admin\Products::update/$1');
   $routes->get('products/delete/(:num)', 'Admin\Products::delete/$1');
    
   // Knowledge Centre Routes
   $routes->get('knowledge-centre/categories', 'Admin\KnowledgeCentre::categories');
   $routes->get('knowledge-centre/create-category', 'Admin\KnowledgeCentre::createCategory');
   $routes->post('knowledge-centre/store-category', 'Admin\KnowledgeCentre::storeCategory');
   $routes->get('knowledge-centre/edit-category/(:num)', 'Admin\KnowledgeCentre::editCategory/$1');
   $routes->post('knowledge-centre/update-category/(:num)', 'Admin\KnowledgeCentre::updateCategory/$1');
   $routes->get('knowledge-centre/delete-category/(:num)', 'Admin\KnowledgeCentre::deleteCategory/$1');

   $routes->get('knowledge-centre/items', 'Admin\KnowledgeCentre::items');
   $routes->get('knowledge-centre/create-item', 'Admin\KnowledgeCentre::createItem');
   $routes->post('knowledge-centre/store-item', 'Admin\KnowledgeCentre::storeItem');
   $routes->get('knowledge-centre/edit-item/(:num)', 'Admin\KnowledgeCentre::editItem/$1');
   $routes->post('knowledge-centre/update-item/(:num)', 'Admin\KnowledgeCentre::updateItem/$1');
   $routes->get('knowledge-centre/delete-item/(:num)', 'Admin\KnowledgeCentre::deleteItem/$1');

   // Substack Updates routes
   $routes->get('substack-updates', 'Admin\SubstackUpdates::index');
   $routes->get('substack-updates/create', 'Admin\SubstackUpdates::create');
   $routes->post('substack-updates/store', 'Admin\SubstackUpdates::store');
   $routes->get('substack-updates/edit/(:num)', 'Admin\SubstackUpdates::edit/$1');
   $routes->post('substack-updates/update/(:num)', 'Admin\SubstackUpdates::update/$1');
   $routes->get('substack-updates/delete/(:num)', 'Admin\SubstackUpdates::delete/$1');
});

