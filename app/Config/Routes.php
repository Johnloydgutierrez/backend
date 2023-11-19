<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/getData', 'MainController::getData');
$routes->post('/save', 'MainController::save');
$routes->get('/Assign', 'AssignController::Assign');
$routes->post('/sve', 'AssignController::sve');
$routes->match(['post','get'],'/login', 'AdminController::login');
$routes->match(['post','get'],'/register', 'AdminController::register');
