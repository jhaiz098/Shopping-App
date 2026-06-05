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