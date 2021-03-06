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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
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
$routes->group('api', ['filter' => 'cors'], function($routes) {
	$routes->get('/', 'Home::index');
	$routes->post('login','Auth::login');
	$routes->post('register','Auth::register');
});
$routes->group('api', ['filter' => 'cors-token'], function($routes) {
	$routes->get('user','Home::user');
	$routes->resource('restaurants', ['except' => 'new,edit', 'placeholder' => '(:num)']);
	$routes->delete('items/(:num)','Items::delete/$1');
	$routes->delete('addons/(:num)','ItemAddons::delete/$1');
	$routes->delete('options/(:num)','ItemAddonOptions::delete/$1');
	$routes->post('image', 'Home::image');
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
