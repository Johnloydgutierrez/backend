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
$routes->post('updateItem/(:any)', 'MainController::updateItem/$1');
$routes->get('/getPartss', 'InvoiceController::getPartss');
$routes->get('/getEList', 'InvoiceController::getEList');
$routes->post('del', 'AssignController::del');
$routes->post('/save-product', 'EbikeController::save');
$routes->get('/ebikepartsGetData', 'MainController::ebikepartsGetData');
$routes->get('/ebikecategGetData', 'EbikeController::ebikecategGetData');
$routes->post('/categsave', 'EbikeController::categsave');
$routes->post('/saveinvoice', 'InvoiceController::saveinvoice');
$routes->post('/saveinvoicep', 'InvoiceController::saveinvoicep');
$routes->get('/getInvoice', 'InvoiceController::getInvoice');
$routes->get('/getCategory', 'InvoiceController::getCategory');
$routes->get('/generatePdf', 'InvoiceController::generatePdf');


