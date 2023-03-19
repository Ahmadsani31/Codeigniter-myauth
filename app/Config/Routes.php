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
$routes->get('/', 'Dashboard::index', ['filter' => 'login']);
// $routes->get('/profil', 'Profil::index', ['filter' => 'login']);
// $routes->post('/profil/upload', 'Profil::upload', ['filter' => 'login']);
$routes->group('profil', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Profil::index', ['filter' => 'permission:read-module']);
    $routes->post('upload', 'Profil::upload', ['filter' => 'permission:read-module']);
    $routes->post('simpan-password', 'Profil::upload', ['filter' => 'permission:read-module']);
    $routes->post('simpan-biodata', 'Profil::simpanBiodata', ['filter' => 'permission:read-module']);
    $routes->post('simpan-password', 'Profil::simpanPassword', ['filter' => 'permission:read-module']);
    $routes->get('select2-daerah', 'Profil::select2Daerah');
});

// $routes->post('datatable', 'Administrator\Datatables::serverSide', ['filter' => 'login']);
// $routes->post('datatable', 'Administrator\Datatables::index', ['filter' => 'login']);

$routes->group('datatable', ['filter' => 'login'], function ($routes) {
    $routes->POST('/',  'Datatables::index');
    $routes->POST('server-side', 'Datatables::serverSide');
});

$routes->POST('modal/(:any)', 'Modal::index', ['filter' => 'login']);

$routes->group('user', ['filter' => 'role:administrator'], function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('group', 'User::group');
    $routes->get('permission', 'User::permission');

    $routes->POST('simpan', 'User::simpanDanUpdate',);
    $routes->POST('group', 'User::simpanDanUpdateGroup',);
    $routes->POST('permission', 'User::simpanDanUpdatePermission',);
});

$routes->group('acara', function ($routes) {
    $routes->get('/', 'Acara::index');
    $routes->get('tampil/(:any)', 'Acara::view/$1/$2');
    $routes->post('simpan', 'Acara::simpan', ['as' => 'save.acara']);
    $routes->post('simpan_sub', 'Acara::simpanSub', ['as' => 'save.acara_sub']);
    $routes->post('setPrioritasUndangan', 'Acara::setPrioritasUndangan', ['as' => 'save.prioritas']);
});

$routes->group('undangan', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Undangan::index');
    $routes->post('simpan', 'Undangan::simpan', ['as' => 'save.undangan']);
    $routes->post('import_excel', 'Undangan::import_excel', ['as' => 'import.undangan']);
    $routes->post('simpan', 'Undangan::simpan', ['as' => 'save.undangan']);
});

$routes->group('dashboard', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('location', 'Dashboard::getLocation');
});

$routes->group('acara', function ($routes) {
    $routes->get('/', 'Acara::index');
    $routes->get('tampil/(:any)', 'Acara::view/$1/$2');
    $routes->post('simpan', 'Acara::simpan', ['as' => 'save.acara']);
    $routes->get('cetak-undangan', 'Acara::cetakNamaUndangan');
    $routes->post('simpan_sub', 'Acara::simpanSub', ['as' => 'save.acara_sub']);
    $routes->post('setPrioritasUndangan', 'Acara::setPrioritasUndangan', ['as' => 'save.prioritas']);

    $routes->get('event-calender', 'Acara::getEventFullcalender');
});

$routes->group('undangan', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Undangan::index');
    $routes->get('cetak/(:num)', 'Undangan::cetakTCPDF/$1');
    $routes->post('simpan', 'Undangan::simpan', ['as' => 'save.undangan']);
    $routes->post('setLabelUndangan', 'Undangan::setLabelUndangan', ['as' => 'save.namaUndangan']);
    $routes->post('import_excel', 'Undangan::import_excel', ['as' => 'import.undangan']);
    $routes->post('simpan', 'Undangan::simpan', ['as' => 'save.undangan']);
});
$routes->POST('delete', 'Delete::index', ['filter' => 'login']);


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
