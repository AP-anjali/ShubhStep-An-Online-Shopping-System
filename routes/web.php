<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CreateAdminController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\OrderController;   // for cheking the refund status functions [in case of cancel or reject]
use App\Http\Controllers\RefundStatusController;   // for cheking the refund status functions [in case of return]
use App\Http\Controllers\SevenDaysStatusController;   // for updating 'is_seven_days_complte_to_delivery' field
use App\Http\Controllers\GoogleController; 


/* ---------------------------- admin data entry ------------------------ */
Route::get('/secret_url_to_create_admin', [CreateAdminController::class, 'createAdmin']);

/* ----------------------------------------------- Main initial page ----------------------------------------------- */

route::get('/', [MainController::class, 'main_initial_page'])->name('main_initial_page');
Route::get('/page-not-found', [MainController::class, 'page_not_found'])->name('page_not_found');
Route::get('/missing-internet-connection', [MainController::class, 'missing_internet_connection'])->name('missing_internet_connection');

/* ----------------------------------------------- Customer registration & login routes ----------------------------------------------- */
route::get('/login-registration', [CustomerController::class, 'customer_login_registration_page'])->name('customer_login_registration_page');
route::post('/customer_registration', [CustomerController::class, 'customer_registration'])->name('customer_registration');
route::post('/email_verification_and_sending_otp', [CustomerController::class, 'email_verification_and_sending_otp'])->name('email_verification_and_sending_otp');
route::post('/otp_verification', [CustomerController::class, 'otp_verification'])->name('otp_verification');
route::get('/customer_logout', [CustomerController::class, 'customer_logout'])->name('customer_logout');

/* ----------------------------------------------- login/registration by GOOGLE ----------------------------------------------- */
route::get('auth/google', [GoogleController::class, 'login_by_google'])->name('login_by_google');
route::any('auth/google/callback', [GoogleController::class, 'callback_from_google_after_authentication'])->name('callback_from_google_after_authentication');


/* ----------------------------------------------- Customer Dashboard ----------------------------------------------- */
route::get('/customer-dashboard', [CustomerController::class, 'customer_dashboard'])->name('customer_dashboard')->middleware('customerAuth');
route::get('/customer-account', [CustomerController::class, 'customer_account'])->name('customer_account')->middleware('customerAuth');
route::post('/adding_address', [CustomerController::class, 'adding_address'])->name('adding_address')->middleware('customerAuth');
route::post('/updating_address', [CustomerController::class, 'updating_address'])->name('updating_address')->middleware('customerAuth');
route::post('/updating_profile', [CustomerController::class, 'updating_profile'])->name('updating_profile')->middleware('customerAuth');
route::post('/updating_profile2', [CustomerController::class, 'updating_profile2'])->name('updating_profile2')->middleware('customerAuth');
route::post('/add_to_wishlist', [CustomerController::class, 'add_to_wishlist'])->name('add_to_wishlist')->middleware('customerAuth');
route::post('/add_to_cart', [CustomerController::class, 'add_to_cart'])->name('add_to_cart')->middleware('customerAuth');
route::post('/buy_now', [CustomerController::class, 'buy_now'])->name('buy_now')->middleware(['customerAuth', 'customerAddressAuth']);
route::post('/checkout', [CustomerController::class, 'checkout'])->name('checkout')->middleware(['customerAuth', 'customerAddressAuth']);

route::get('/customer-cart', [CustomerController::class, 'customer_cart'])->name('customer_cart')->middleware('customerAuth');
route::get('/remove_from_cart/{cart_id}', [CustomerController::class, 'remove_from_cart'])->name('remove_from_cart')->middleware('customerAuth');
route::post('/updating_cart_record', [CustomerController::class, 'updating_cart_record'])->name('updating_cart_record')->middleware('customerAuth');

route::get('/customer-wishlist', [CustomerController::class, 'customer_wishlist'])->name('customer_wishlist')->middleware('customerAuth');
route::get('/remove_from_wishlist/{wishlist_id}', [CustomerController::class, 'remove_from_wishlist'])->name('remove_from_wishlist')->middleware('customerAuth');

route::get('/customer-orders', [CustomerController::class, 'customer_orders'])->name('customer_orders')->middleware('customerAuth');
route::get('/cancelled-orders', [CustomerController::class, 'cancelled_orders'])->name('cancelled_orders')->middleware('customerAuth');
route::get('/rejected-orders', [CustomerController::class, 'rejected_orders'])->name('rejected_orders')->middleware('customerAuth');
route::get('/completed-orders', [CustomerController::class, 'completed_orders'])->name('completed_orders')->middleware('customerAuth');
route::get('/exchanged-orders', [CustomerController::class, 'exchanged_orders'])->name('exchanged_orders')->middleware('customerAuth');
route::get('/returned-orders', [CustomerController::class, 'returned_orders'])->name('returned_orders')->middleware('customerAuth');

route::post('/remove_order', [CustomerController::class, 'remove_order'])->name('remove_order')->middleware('customerAuth');

route::post('/order-feedback-form', [CustomerController::class, 'order_feedback_form'])->name('order_feedback_form')->middleware('customerAuth');
route::post('/storing_feedback', [CustomerController::class, 'storing_feedback'])->name('storing_feedback')->middleware('customerAuth');

route::post('/return_request_reason_form', [CustomerController::class, 'return_request_reason_form'])->name('return_request_reason_form')->middleware('customerAuth');
route::post('/return_request', [CustomerController::class, 'return_request'])->name('return_request')->middleware('customerAuth');
route::post('/canceling_return_request', [CustomerController::class, 'canceling_return_request'])->name('canceling_return_request')->middleware('customerAuth');

route::post('/exchange_request_reason_form', [CustomerController::class, 'exchange_request_reason_form'])->name('exchange_request_reason_form')->middleware('customerAuth');
route::post('/exchange_request', [CustomerController::class, 'exchange_request'])->name('exchange_request')->middleware('customerAuth');
route::post('/canceling_exchange_request', [CustomerController::class, 'canceling_exchange_request'])->name('canceling_exchange_request')->middleware('customerAuth');

route::get('/customer-exchange-request', [CustomerController::class, 'customer_new_exchange_request'])->name('customer_new_exchange_request')->middleware('customerAuth');
route::get('/customer-return-request', [CustomerController::class, 'customer_new_returne_request'])->name('customer_new_returne_request')->middleware('customerAuth');

/* ------------------ product details ------------------ */
route::get('/product-details/{id}', [CustomerController::class, 'product_details'])->name('product_details');
route::get('/Event/{event_name}/{sub_event_name}/{sub_event_id}', [CustomerController::class, 'product_of_specific_sub_event'])->name('product_of_specific_sub_event');

/* ------------------ buy product ------------------ */
route::get('/go_to_register_address', [CustomerController::class, 'go_to_register_address'])->name('go_to_register_address')->middleware('customerAuth');
route::get('/go_to_register_only_phone_number', [CustomerController::class, 'go_to_register_only_phone_number'])->name('go_to_register_only_phone_number')->middleware('customerAuth');
route::get('/both', [CustomerController::class, 'both'])->name('both')->middleware('customerAuth');
Route::post('/payment_of_single_product', [RazorpayPaymentController::class, 'payment_of_single_product'])->name('payment_of_single_product')->middleware('customerAuth');
Route::post('/payment_of_single_product_COD', [RazorpayPaymentController::class, 'payment_of_single_product_COD'])->name('payment_of_single_product_COD')->middleware('customerAuth');
Route::post('/payment_of_wholesale_product', [RazorpayPaymentController::class, 'payment_of_wholesale_product'])->name('payment_of_wholesale_product')->middleware('customerAuth');
Route::post('/payment_of_wholesale_product_COD', [RazorpayPaymentController::class, 'payment_of_wholesale_product_COD'])->name('payment_of_wholesale_product_COD')->middleware('customerAuth');

route::post('/cancel_order_reason_form', [CustomerController::class, 'cancel_order_reason_form'])->name('cancel_order_reason_form')->middleware('customerAuth');
Route::post('/order/cancel/{id}', [RazorpayPaymentController::class, 'cancelOrder'])->name('order.cancel');

route::post('/cancel_order_reason_form2', [CustomerController::class, 'cancel_order_reason_form2'])->name('cancel_order_reason_form2')->middleware('customerAuth');
route::post('/order_cancel_COD/{id}', [RazorpayPaymentController::class, 'order_cancel_COD'])->name('order_cancel_COD')->middleware('customerAuth');


/* ----------------------------------------------- ADMIN DASHBOARD [starts] ----------------------------------------------- */
route::get('/admin-dashboard', [AdminController::class, 'admin_dashboard'])->name('admin_dashboard')->middleware('adminAuth');
route::get('/admin_settings_page', [AdminController::class, 'admin_settings_page'])->name('admin_settings_page')->middleware('adminAuth');
route::get('/admin-account', [AdminController::class, 'admin_account'])->name('admin_account')->middleware('adminAuth');
route::get('/send_otp_to_admin', [AdminController::class, 'send_otp_to_admin'])->name('send_otp_to_admin')->middleware('adminAuth');
route::post('/verify_admin_otp', [AdminController::class, 'verify_admin_otp'])->name('verify_admin_otp')->middleware('adminAuth');
route::post('/updating_admin_details', [AdminController::class, 'updating_admin_details'])->name('updating_admin_details')->middleware('adminAuth');
route::post('/updating_admin_details2', [AdminController::class, 'updating_admin_details2'])->name('updating_admin_details2')->middleware('adminAuth');
route::get('/admin_logout', [AdminController::class, 'admin_logout'])->name('admin_logout');
route::get('/admin-dashboard2', [AdminController::class, 'admin_dashboard2'])->name('admin_dashboard2')->middleware('adminAuth');


/* ----------------------------------------------- Events ----------------------------------------------- */
route::get('/events', [AdminController::class, 'admin_dahboard_events_page'])->name('admin_dahboard_events_page')->middleware('adminAuth');
route::post('/adding_event', [AdminController::class, 'adding_event'])->name('adding_event')->middleware('adminAuth');
route::post('/updating_event', [AdminController::class, 'updating_event'])->name('updating_event')->middleware('adminAuth');
Route::get('/activating_event/{id}', [AdminController::class, 'activating_event'])->name('activating_event')->middleware('adminAuth');
Route::get('/deactivating_event/{id}', [AdminController::class, 'deactivating_event'])->name('deactivating_event')->middleware('adminAuth');
Route::get('/deleting_event/{id}', [AdminController::class, 'deleting_event'])->name('deleting_event')->middleware('adminAuth');


/* ----------------------------------------------- Sub-events ----------------------------------------------- */
route::get('/sub-events', [AdminController::class, 'admin_dahboard_sub_events_page'])->name('admin_dahboard_sub_events_page')->middleware('adminAuth');
route::post('/adding_sub_event', [AdminController::class, 'adding_sub_event'])->name('adding_sub_event')->middleware('adminAuth');
route::post('/updating_sub_event/{id}', [AdminController::class, 'updating_sub_event'])->name('updating_sub_event')->middleware('adminAuth');
Route::get('/activating_sub_event/{id}', [AdminController::class, 'activating_sub_event'])->name('activating_sub_event')->middleware('adminAuth');
Route::get('/deactivating_sub_event/{id}', [AdminController::class, 'deactivating_sub_event'])->name('deactivating_sub_event')->middleware('adminAuth');
Route::get('/deleting_sub_event/{id}', [AdminController::class, 'deleting_sub_event'])->name('deleting_sub_event')->middleware('adminAuth');


/* ----------------------------------------------- Products ----------------------------------------------- */
route::get('/products', [AdminController::class, 'admin_dashboard_add_products_page'])->name('admin_dashboard_add_products_page')->middleware('adminAuth');
route::get('/products2', [AdminController::class, 'admin_dashboard_products_page'])->name('admin_dashboard_products_page')->middleware('adminAuth');
route::get('/all-products', [AdminController::class, 'admin_dashboard_all_products_page'])->name('admin_dashboard_all_products_page')->middleware('adminAuth');
route::post('/adding_product', [AdminController::class, 'adding_product'])->name('adding_product')->middleware('adminAuth');
route::post('/edit-product', [AdminController::class, 'admin_dashboard_edit_product_page'])->name('admin_dashboard_edit_product_page')->middleware('adminAuth');
route::post('/updating_product/{id}', [AdminController::class, 'updating_product'])->name('updating_product')->middleware('adminAuth');
Route::get('/activating_product/{id}', [AdminController::class, 'activating_product'])->name('activating_product')->middleware('adminAuth');
Route::get('/deactivating_product/{id}', [AdminController::class, 'deactivating_product'])->name('deactivating_product')->middleware('adminAuth');
Route::get('/deleting_product/{id}', [AdminController::class, 'deleting_product'])->name('deleting_product')->middleware('adminAuth');


/* ----------------------------------------------- Orders ----------------------------------------------- */
route::get('/admin-new-orders', [AdminController::class, 'admin_new_orders'])->name('admin_new_orders')->middleware('adminAuth');
route::post('/customer-details', [AdminController::class, 'customer_details_for_order'])->name('customer_details_for_order')->middleware('adminAuth');
Route::get('/accepting_order/{id}', [AdminController::class, 'accepting_order'])->name('accepting_order')->middleware('adminAuth');
Route::post('/order_reject_reason_form', [AdminController::class, 'order_reject_reason_form'])->name('order_reject_reason_form')->middleware('adminAuth');
route::post('/order_reject/{id}', [AdminController::class, 'order_reject'])->name('order_reject')->middleware('adminAuth');
route::get('/admin-cancelled-orders', [AdminController::class, 'admin_cancelled_orders'])->name('admin_cancelled_orders')->middleware('adminAuth');
route::get('/admin-rejected-orders', [AdminController::class, 'admin_rejected_orders'])->name('admin_rejected_orders')->middleware('adminAuth');
Route::get('/order_reject_undo/{id}', [AdminController::class, 'order_reject_undo'])->name('order_reject_undo')->middleware('adminAuth');
route::get('/admin-accepted-orders', [AdminController::class, 'admin_accepted_orders'])->name('admin_accepted_orders')->middleware('adminAuth');
Route::get('/undo_order_acceptance/{id}', [AdminController::class, 'undo_order_acceptance'])->name('undo_order_acceptance')->middleware('adminAuth');
Route::get('/mark_order_as_ready/{id}', [AdminController::class, 'mark_order_as_ready'])->name('mark_order_as_ready')->middleware('adminAuth');
route::get('/admin-ready-orders', [AdminController::class, 'admin_ready_orders'])->name('admin_ready_orders')->middleware('adminAuth');
Route::get('/undo_order_ready_mark/{id}', [AdminController::class, 'undo_order_ready_mark'])->name('undo_order_ready_mark')->middleware('adminAuth');

Route::get('/send_otp_to_customer_for_verification/{id}', [AdminController::class, 'send_otp_to_customer_for_verification'])->name('send_otp_to_customer_for_verification')->middleware('adminAuth');
route::get('/delivery-otp-verification', [AdminController::class, 'delivery_otp_verification_form'])->name('delivery_otp_verification_form')->middleware('adminAuth');
route::post('/delivery_otp_verification_process', [AdminController::class, 'delivery_otp_verification_process'])->name('delivery_otp_verification_process')->middleware('adminAuth');

route::get('/admin-completed-orders', [AdminController::class, 'admin_completed_orders'])->name('admin_completed_orders')->middleware('adminAuth');
route::get('/admin-exchange-request', [AdminController::class, 'admin_new_exchange_request'])->name('admin_new_exchange_request')->middleware('adminAuth');
Route::get('/accepting_exchange_request/{id}', [AdminController::class, 'accepting_exchange_request'])->name('accepting_exchange_request')->middleware('adminAuth');
route::get('/admin-accepted-exchange-request', [AdminController::class, 'admin_accepted_exchange_request'])->name('admin_accepted_exchange_request')->middleware('adminAuth');
Route::get('/undo_order_exchange_request_acceptance/{id}', [AdminController::class, 'undo_order_exchange_request_acceptance'])->name('undo_order_exchange_request_acceptance')->middleware('adminAuth');

Route::get('/send_otp_to_customer_for_exchange_verification/{id}', [AdminController::class, 'send_otp_to_customer_for_exchange_verification'])->name('send_otp_to_customer_for_exchange_verification')->middleware('adminAuth');
route::get('/exchange-otp-verification', [AdminController::class, 'exchange_otp_verification_form'])->name('exchange_otp_verification_form')->middleware('adminAuth');
route::post('/exchange_otp_verification_process', [AdminController::class, 'exchange_otp_verification_process'])->name('exchange_otp_verification_process')->middleware('adminAuth');

route::get('/admin-exchanged-orders', [AdminController::class, 'admin_exchanged_orders'])->name('admin_exchanged_orders')->middleware('adminAuth');

route::get('/admin-return-request', [AdminController::class, 'admin_new_return_request'])->name('admin_new_return_request')->middleware('adminAuth');
Route::get('/accepting_return_request/{id}', [AdminController::class, 'accepting_return_request'])->name('accepting_return_request')->middleware('adminAuth');
route::get('/admin-accepted-return-request', [AdminController::class, 'admin_accepted_return_request'])->name('admin_accepted_return_request')->middleware('adminAuth');
Route::get('/undo_order_return_request_acceptance/{id}', [AdminController::class, 'undo_order_return_request_acceptance'])->name('undo_order_return_request_acceptance')->middleware('adminAuth');

Route::get('/send_otp_to_customer_for_return_verification/{id}', [AdminController::class, 'send_otp_to_customer_for_return_verification'])->name('send_otp_to_customer_for_return_verification')->middleware('adminAuth');
route::get('/return-otp-verification', [AdminController::class, 'return_otp_verification_form'])->name('return_otp_verification_form')->middleware('adminAuth');
route::post('/return_otp_verification_process', [AdminController::class, 'return_otp_verification_process'])->name('return_otp_verification_process')->middleware('adminAuth');

route::get('/admin-returned-orders', [AdminController::class, 'admin_returned_orders'])->name('admin_returned_orders')->middleware('adminAuth');

route::get('/orders-feedback', [AdminController::class, 'orders_feedback'])->name('orders_feedback')->middleware('adminAuth');
route::get('/contact-mails', [AdminController::class, 'contact_mails'])->name('contact_mails')->middleware('adminAuth');
route::get('/customer-support-mails', [AdminController::class, 'customer_support_mails'])->name('customer_support_mails')->middleware('adminAuth');
route::get('/platform-feedback', [AdminController::class, 'platform_feedback'])->name('platform_feedback')->middleware('adminAuth');

/* ----------------------------------------------------- footer pages ----------------------------------------------------- */
route::get('/contact-us', [MainController::class, 'contact_us'])->name('contact_us');
route::get('/redirect-route', [MainController::class, 'redirect_route'])->name('redirect_route');
route::get('/redirecting_short_service', [MainController::class, 'redirecting_short_service'])->name('redirecting_short_service');
route::get('/redirecting_payment_methods', [MainController::class, 'redirecting_payment_methods'])->name('redirecting_payment_methods');
route::get('/redirecting_return_policy', [MainController::class, 'redirecting_return_policy'])->name('redirecting_return_policy');
route::get('/redirecting_refund_policy', [MainController::class, 'redirecting_refund_policy'])->name('redirecting_refund_policy');
route::get('/redirecting_exchange_policy', [MainController::class, 'redirecting_exchange_policy'])->name('redirecting_exchange_policy');
route::get('/form', [MainController::class, 'form'])->name('form');
route::post('/contact_us_form_submit', [MainController::class, 'contact_us_form_submit'])->name('contact_us_form_submit');

route::get('/customer-support', [MainController::class, 'customer_support'])->name('customer_support');
route::post('/customer_support_form_submit', [MainController::class, 'customer_support_form_submit'])->name('customer_support_form_submit');

route::get('/feedback-form', [MainController::class, 'feedback_form'])->name('feedback_form');
route::post('/feedback_form_submit', [MainController::class, 'feedback_form_submit'])->name('feedback_form_submit');

route::get('/developer-anjali-patel', [MainController::class, 'anjali_patel'])->name('anjali_patel');

route::get('/about-us', [MainController::class, 'about_us'])->name('about_us');
route::get('/terms-and-conditions', [MainController::class, 'terms_and_conditions'])->name('terms_and_conditions');
route::get('/privacy-policy', [MainController::class, 'privacy_policy'])->name('privacy_policy');
route::get('/FAQs', [MainController::class, 'FAQs'])->name('FAQs');
