<?php

namespace Config;

use CodeIgniter\Routing\RouteCollection;

$routes = Services::routes();

// Rute untuk halaman utama
$routes->get('/', 'SportShopController::index');
$routes->get('/shop/search', 'SportShopController::search');


// Rute default untuk halaman tidak ditemukan (404)


// Rute untuk autentikasi
$routes->get('login', 'AuthController::login');
$routes->post('login_process', 'AuthController::login_process');
$routes->get('register', 'AuthController::register');
$routes->post('register_process', 'AuthController::register_process');
$routes->get('/verify-otp', 'AuthController::verifyOtp');
$routes->post('/verify-otp', 'AuthController::verifyOtp');
$routes->get('logout', 'AuthController::logout');

// Rute untuk halaman admin

$routes->group('', ['filter' => 'adminAuth'], function ($routes) {
    $routes->get('admin', 'AdminController::manage_products');
    $routes->get('admin/products', 'AdminController::manage_products');
    $routes->get('admin/products/add', 'AdminController::add_product');
    $routes->post('admin/products/insert', 'AdminController::insert_product');
    $routes->get('admin/products/edit/(:segment)', 'AdminController::edit_product/$1');
    $routes->post('admin/products/update/(:segment)', 'AdminController::update_product/$1');
    $routes->get('admin/products/delete/(:segment)', 'AdminController::delete_product/$1');
    $routes->get('admin/banners', 'AdminController::manage_banners');
    $routes->get('admin/banners/create', 'AdminController::add_banner');
    $routes->post('admin/banners/store', 'AdminController::insert_banner');
    $routes->get('admin/banners/edit/(:segment)', 'AdminController::edit_banner/$1');
    $routes->post('admin/banners/update/(:segment)', 'AdminController::update_banner/$1');
    $routes->get('admin/banners/delete/(:segment)', 'AdminController::delete_banner/$1');
    $routes->get('admin/categories', 'AdminController::manage_categories');
    $routes->get('admin/categories/create', 'AdminController::add_category');
    $routes->post('admin/categories/store', 'AdminController::insert_category');
    $routes->get('admin/categories/edit/(:segment)', 'AdminController::edit_category/$1');
    $routes->post('admin/categories/update/(:segment)', 'AdminController::update_category/$1');
    $routes->get('admin/categories/delete/(:segment)', 'AdminController::delete_category/$1');
    $routes->get('/admin/orders', 'OrderController::adminOrders');
    $routes->get('/admin/orders/ship/(:segment)', 'OrderController::shipOrder/$1');
    $routes->get('/admin/orders/receive/(:segment)', 'OrderController::receiveOrder/$1');
    $routes->get('/admin/report', 'OrderController::generateReport');
});

$routes->group('', ['filter' => 'ownerAuth'], function ($routes) {
    $routes->get('/owner', 'OrderController::ownerOrders');
    $routes->get('/owner/report/', 'OrderController::generateReport');
});

$routes->group('', ['filter' => 'userAuth'], function ($routes) {
    $routes->get('/cart', 'SportShopController::viewCart');
    $routes->get('cart/add/(:num)', 'SportShopController::addToCart/$1');
    $routes->post('/checkout', 'SportShopController::checkout');
    $routes->get('cart/increase/(:num)', 'SportShopController::increaseQuantity/$1');
    $routes->get('cart/decrease/(:num)', 'SportShopController::decreaseQuantity/$1');
    $routes->get('remove/(:num)', 'SportShopController::removeItem/$1');
    $routes->get('/order-success', 'SportShopController::orderSuccess');
    $routes->get('/orders', 'OrderController::userOrders');
    $routes->get('/orders/receive/(:segment)', 'OrderController::receiveOrder/$1');
    $routes->get('payment', 'PaymentController::index');
    $routes->post('/checkout/process', 'PaymentController::checkout');
    $routes->get('/payment/token', 'PaymentController::getToken');
    $routes->post('payment/finish', 'PaymentController::finish');
    $routes->get('payment/success', 'PaymentController::success');
});


// Eksekusi rute
return $routes;
