<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('search', 'Home::search');

$routes->get('cart', 'Home::cart');
$routes->get('cart/add/(:num)', 'Cart::add_to_cart/$1');

$routes->get('register', 'Auth::register');
$routes->post('register/auth', 'Auth::registerAuth');

$routes->get('login', 'Auth::login');
$routes->post('login/auth', 'Auth::loginAuth');

$routes->get('logout', 'Auth::logout');



$routes->group('admin', ['filter' => 'admin'], function($routes)
{
    $routes->get('/', 'Admin\Admin::dashboard');

    $routes->get('categories', 'Admin\Admin::categories');
    $routes->post('categories/add', 'Admin\Categories::add_category');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update_category/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete_category/$1');
    
    $routes->get('products', 'Admin\Admin::products');
    $routes->post('products/add', 'Admin\Products::add_product');
    $routes->post('products/update/(:num)', 'Admin\Products::update_product/$1');
    $routes->get('products/delete/(:num)', 'Admin\Products::delete_product/$1');

    $routes->get('orders', 'Admin\Admin::orders');

    $routes->get('users', 'Admin\Admin::users');
    $routes->post('users/add', 'Admin\Users::add_user');
    $routes->post('users/update/(:num)', 'Admin\Users::update_user/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete_user/$1');
    });