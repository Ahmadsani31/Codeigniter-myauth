<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('/', 'Home::index', ['filter' => 'login']);

// $routes->post('datatable', 'Administrator\Datatables::serverSide', ['filter' => 'login']);
// $routes->post('datatable', 'Administrator\Datatables::index', ['filter' => 'login']);

$routes->group('datatable', ['filter' => 'login'], function ($routes) {
    $routes->POST('/',  'Administrator\Datatables::index');
    $routes->POST('server-side', 'Administrator\Datatables::serverSide');
});

$routes->POST('admin-modal/(:any)', 'Administrator\Modal::index', ['filter' => 'login']);

$routes->group('admin', ['filter' => 'login'], function ($routes) {
    $routes->get('user', 'Administrator\User::index');
    $routes->get('group', 'Administrator\User::group');
    $routes->get('permission', 'Administrator\User::permission');

    $routes->POST('user', 'Administrator\User::simpanDanUpdate',);
    $routes->POST('group', 'Administrator\User::simpanDanUpdateGroup',);
    $routes->POST('permission', 'Administrator\User::simpanDanUpdatePermission',);
});

$routes->get('admin-dashboard', 'Administrator\Dashboard::index', ['filter' => 'role:administrator,login']);

$routes->POST('admin-delete', 'Administrator\Delete::index', ['filter' => 'login']);


$routes->get('login', 'AuthController::login', ['as' => 'login']);

$routes->get('logout', 'AuthController::logout');

$routes->get('register', 'AuthController::register', ['as' => 'register']);
$routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
$routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);
// $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
$routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);

$routes->POST('login', 'AuthController::attemptLogin');
$routes->POST('register', 'AuthController::attemptRegister');
$routes->POST('forgot', 'AuthController::attemptForgot');
$routes->POST('reset-password', 'AuthController::attemptReset');

$routes->add('user/(:num)/edit', 'Administrator\User::edit/$1');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
