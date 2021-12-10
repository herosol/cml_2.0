<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['404_override'] = 'pages/error';
$route['translate_uri_dashes'] = FALSE;

# SITE PAGES
$route['landing'] = 'pages/landing';
$route['promotions-offers'] = 'pages/promotions';
$route['about-us'] = 'pages/about';
$route['faq'] = 'pages/faq';
$route['contact'] = 'pages/contact';
$route['blogs'] = 'blogs/index';
$route['blog-detail/(:any)/(:any)'] = 'blogs/blog_detail/$1/$2';
$route['terms-conditions'] = 'pages/terms_conditions';
$route['privacy-policy'] = 'pages/privacy_policy';
$route['impact'] = 'pages/impact';
# AUTHENTICATION PAGES
$route['signup-as']       = 'index/signup_as';
$route['(:any)/signup']   = 'index/signup/$1';
$route['signin']          = 'index/signin';
$route['forgot-password'] = 'index/forgot_password';
$route['reset/(:any)']    = 'index/reset/$1';
$route['reset-password']  = 'index/reset_password';
$route['resend-email']    = 'index/resend_email';
$route['verification/(:any)'] = 'index/verification/$1';
$route['newsletter']          = 'index/newsletter';

$route['facebook-login']    = 'index/facebook_login';
$route['facebook-callback'] = 'index/facebook_callback';
$route['google-login']      = 'index/google_login';
$route['google-callback']   = 'index/google_callback';
# VENDOR PAGES
$route['vendor/dashboard']  = 'vendor/dashboard';
$route['vendor/notifications']     = 'vendor/notifications';
$route['vendor/orders']     = 'vendor/orders';
$route['vendor/order-detail/(:any)'] = 'vendor/order_detail/$1';
$route['vendor/price-list'] = 'vendor/price_list';
$route['vendor/facility-hours'] = 'vendor/facility_hours';
$route['vendor/wallet']         = 'earnings/index';
$route['vendor/credits']        = 'vendor/credits';
$route['vendor/bank-accounts']  = 'vendor/bank_accounts';
# BUYER PAGES
$route['buyer/dashboard']   = 'buyer/dashboard';
$route['buyer/notifications']      = 'buyer/notifications';
$route['buyer/orders']      = 'buyer/orders';
$route['buyer/credits']     = 'buyer/credits';
$route['buyer/order-detail/(:any)'] = 'buyer/order_detail/$1';
$route['buyer/wallet']      = 'buyer/transactions';

# SITE PAGES
$route['service-selection'] = 'search/service_selection';
$route['available-vendors'] = 'search/available_vendor';
$route['vendor-detail/(:any)/(:any)'] = 'search/vendor_detail/$1/$2';
$route['order-booking/(:any)/(:any)'] = 'booking/index/$1/$2';
# ADMIN
$route['admin/login']     = 'admin/index/login';
$route['admin/logout']    = 'admin/index/logout';
$route['admin/meta-info'] = 'admin/Meta_info/index';
$route['admin/pending-proof'] = 'admin/delivery_proof';
$route['admin/rejected-proof'] = 'admin/delivery_proof';
$route['admin/accepted-proof'] = 'admin/delivery_proof';
$route['admin/delivery_proof/manage/(:any)'] = 'admin/delivery_proof/manage';
$route['admin/meta-info/manage'] = 'admin/Meta_info/manage';
$route['admin/meta-info/manage/(:any)'] = 'admin/Meta_info/manage/$1';
$route['admin/meta-info/delete/(:any)'] = 'admin/Meta_info/delete/$1';

#PAYPAL
$route['pay-now/(:num)'] = 'paypal/pay_now/$1';
$route['success/(:any)'] = 'booking/success/$1';
$route['cancel']  = 'booking/cancel';
$route['order-notify']   = 'paypal/order_notify';
$route['paypal/(:any)']  =  'Pages/paypal/$1';
$route['paypal-amended-invoice/(:any)'] =  'Pages/paypal_amended_invoice/$1';

$route['order-success/(:any)'] = 'booking/success/$1';
$route['order-cancel/(:any)']  = 'booking/cancel/$1';
