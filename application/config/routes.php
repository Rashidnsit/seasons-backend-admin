<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// DashboardController
$route['admin/dashboard'] = 'DashboardController/index';

$route['admin/total-sales-get'] = 'AdminController/total_sales_get';

//AdminLogin
$route['admin/login'] = 'AdminController/login';
$route['admin/login-admin'] = 'AdminController/login_admin';
$route['admin/logout'] = 'AdminController/logout';

// AdminProfile
$route['admin/profile'] = 'AdminController/admin_profile';
$route['admin/admin-edit'] = 'AdminController/admin_edit';
$route['admin/change-password'] = 'AdminController/change_password';

//User
$route['admin/user-list'] = 'AdminController/list_user';
// $route['admin/create-user'] = 'AdminController/create_user';
// $route['admin/add-user'] = 'AdminController/add_user';
$route['admin/edit-user/(:any)'] = 'AdminController/edit_user/$1';
$route['admin/update-user'] = 'AdminController/update_user';
$route['admin/trash-user'] = 'AdminController/trash_user';

//Vendor
$route['admin/vendor-list'] = 'AdminController/list_vendor';
$route['admin/create-vendor'] = 'AdminController/create_vendor';
$route['admin/add-vendor'] = 'AdminController/add_vendor';
$route['admin/edit-vendor/(:any)'] = 'AdminController/edit_vendor/$1';
$route['admin/update-vendor'] = 'AdminController/update_vendor';
$route['admin/trash-vendor'] = 'AdminController/trash_vendor';

//Likes
$route['admin/likes-list'] = 'AdminController/list_likes';
$route['admin/like-view/(:any)'] = 'AdminController/likeview/$1';

//Reviews
$route['admin/reviews-list'] = 'AdminController/list_reviews';
$route['admin/reviews-view/(:any)'] = 'AdminController/reviews_view/$1';
$route['admin/trash-reviews'] = 'AdminController/trash_reviews';

//Category
$route['admin/category-list'] = 'AdminController/list_category';
$route['admin/create-category'] = 'AdminController/create_category';
$route['admin/add-category'] = 'AdminController/add_category';
$route['admin/edit-category/(:any)'] = 'AdminController/edit_category/$1';
$route['admin/update-category'] = 'AdminController/update_category';
$route['admin/trash-category'] = 'AdminController/trash_category';

//Sub Category
$route['admin/sub-category-list'] = 'AdminController/list_sub_category';
$route['admin/create-sub-category'] = 'AdminController/create_sub_category';
$route['admin/add-sub-category'] = 'AdminController/add_sub_category';
$route['admin/edit-sub-category/(:any)'] = 'AdminController/edit_sub_category/$1';
$route['admin/update-sub-category'] = 'AdminController/update_sub_category';
$route['admin/trash-sub-category'] = 'AdminController/trash_sub_category';

//Restaurants
$route['admin/restaurants-list'] = 'AdminController/list_restaurants';
$route['admin/create-restaurants'] = 'AdminController/create_restaurants';
$route['admin/add-restaurants'] = 'AdminController/add_restaurants';
$route['admin/edit-restaurants/(:any)'] = 'AdminController/edit_restaurants/$1';
$route['admin/update-restaurants'] = 'AdminController/update_restaurants';
$route['admin/trash-restaurants'] = 'AdminController/trash_restaurants';

//Banners
$route['admin/banners-list'] = 'AdminController/list_banners';
$route['admin/create-banners'] = 'AdminController/create_banners';
$route['admin/add-banners'] = 'AdminController/add_banners';
$route['admin/edit-banners/(:any)'] = 'AdminController/edit_banners/$1';
$route['admin/update-banners'] = 'AdminController/update_banners';
$route['admin/trash-banners'] = 'AdminController/trash_banners';

//Type
$route['admin/type-list'] = 'AdminController/list_type';
$route['admin/create-type'] = 'AdminController/create_type';
$route['admin/add-type'] = 'AdminController/add_type';
$route['admin/edit-type/(:any)'] = 'AdminController/edit_type/$1';
$route['admin/update-type'] = 'AdminController/update_type';
$route['admin/trash-type'] = 'AdminController/trash_type';


//Booking List
$route['admin/booking-list'] = 'AdminController/list_booking';
$route['admin/view-booking/(:any)'] = 'AdminController/view_booking/$1';
$route['admin/trash-booking'] = 'AdminController/trash_booking';

$route['admin/change-booking-status'] = 'AdminController/change_booking_status';


//Product Category
$route['admin/product-category-list'] = 'AdminController/list_product_category';
$route['admin/create-product-category'] = 'AdminController/create_product_category';
$route['admin/add-product-category'] = 'AdminController/add_product_category';
$route['admin/edit-product-category/(:any)'] = 'AdminController/edit_product_category/$1';
$route['admin/update-product-category'] = 'AdminController/update_product_category';
$route['admin/trash-product-category'] = 'AdminController/trash_product_category';


//Product
$route['admin/product-list'] = 'AdminController/list_product';
$route['admin/create-product'] = 'AdminController/create_product';
$route['admin/add-product'] = 'AdminController/add_product';
$route['admin/edit-product/(:any)'] = 'AdminController/edit_product/$1';
$route['admin/update-product'] = 'AdminController/update_product';
$route['admin/trash-product'] = 'AdminController/trash_product';


// Orders
$route['admin/orders'] = 'AdminController/list_orders';
$route['admin/view-order/(:any)'] = 'AdminController/view_order/$1';

$route['admin/change-status'] = 'AdminController/change_status';

$route['admin/trash-orders'] = 'AdminController/trash_orders';


// General Setting
$route['admin/general-setting'] = 'AdminController/general_setting';

$route['admin/update-general-setting'] = 'AdminController/update_general_setting';