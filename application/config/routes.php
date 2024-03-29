<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth/Login';
$route['login'] = 'Auth/Login';
$route['logout'] = 'Auth/logout';
$route['users'] = 'DashboardController/users';
$route['edit-user/(:any)'] = 'DashboardController/edit_user/$1';
$route['add-user'] = 'DashboardController/add_user';
$route['update-user'] = 'DashboardController/update_user';
$route['delete-user'] = 'DashboardController/delete_user';
$route['active-user/(:any)'] = 'DashboardController/active_user/$1';
$route['deactivate-user/(:any)'] = 'DashboardController/deactivate_user/$1';
$route['dashboard'] = 'DashboardController/Dashboard';
$route['profile'] = 'DashboardController/Profile';
$route['update-profile'] = 'DashboardController/update_profile';
$route['product-entry'] = 'DashboardController/product_entry';
$route['product-list'] = 'DashboardController/product_list';
$route['total-product-quantity'] = 'DashboardController/total_product_quantity';
$route['issue-product-list'] = 'DashboardController/issue_product_list';
$route['update-entry'] = 'DashboardController/update_entry';
$route['edit-entry'] = 'DashboardController/edit_entry';
$route['search-product'] = 'DashboardController/search_product';
$route['show-entry'] = 'DashboardController/show_entry';
$route['show-vendor'] = 'DashboardController/show_vendor';
$route['entry-by-date'] = 'DashboardController/entry_by_date';
$route['issue-product'] = 'DashboardController/issue_product';
$route['show-vendor-name'] = 'DashboardController/show_vendor_name';
$route['show-two-type-data'] = 'DashboardController/show_two_type_data';
$route['issue-view'] = 'DashboardController/issue_view';
$route['search-issue'] = 'DashboardController/search_issue';
$route['quantity_issue'] = 'DashboardController/quantity_issue';
$route['inventory'] = 'DashboardController/inventory';
$route['single-product/(:any)'] = 'DashboardController/single_product/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
