<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Authenticate');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Authenticate::login');
$routes->get('/login', 'Authenticate::login');
$routes->get('/logout', 'Authenticate::logout');
$routes->post('/authenticate', 'Authenticate::authenticate');
$routes->get('/register', 'Authenticate::register');
$routes->post('/proses_register', 'Authenticate::proses_register');

$routes->group('admin', ['filter' => 'auth'], function($routes) {
	$routes->get('dashboard', 'Dashboard::index');
	$routes->get('dashboard/get-chart', 'Dashboard::get_chart_json');
	// category
	$routes->get('category', 'Category::index');
	$routes->post('category/get-data-ajax', 'Category::ajax_load_data');
	$routes->post('category/store', 'Category::store');
	$routes->get('category/edit/(:num)', 'Category::edit/$1');
	$routes->post('category/update/(:num)', 'Category::update/$1');
	$routes->get('category/delete/(:num)', 'Category::delete/$1');
	// product
	$routes->get('product', 'Product::index');
	$routes->post('product/get-data-ajax', 'Product::ajax_load_data');
	$routes->post('product/store', 'Product::store');
	$routes->get('product/edit/(:num)', 'Product::edit/$1');
	$routes->get('product/delete/(:num)', 'Product::delete/$1');
	// transaction
	$routes->get('transaction', 'Transaction::index');
	$routes->post('transaction/get-data-ajax', 'Transaction::ajax_load_data');
	$routes->post('transaction/store', 'Transaction::store');
	$routes->get('transaction/edit/(:num)', 'Transaction::edit/$1');
	$routes->get('transaction/delete/(:num)', 'Transaction::delete/$1');
	$routes->get('transaction/get-price', 'Transaction::get_price_product');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
