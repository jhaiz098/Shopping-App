<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::register');
$routes->post('/register/auth', 'Auth::registerAuth');

$routes->get('/login', 'Auth::login');
$routes->post('/login/auth', 'Auth::loginAuth');

$routes->get('/logout', 'Auth::logout');



$routes->group('admin', ['filter' => 'admin'], function($routes)
{
    $routes->get('/', 'Admin\Admin::dashboard');

    $routes->get('categories', 'Admin\Admin::categories');
    $routes->post('categories/add', 'Admin\Categories::add_category');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update_category/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete_category/$1');
});