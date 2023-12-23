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
$routes->post('updateI/(:any)', 'EbikeController::updateI/$1');
$routes->get('/ebikepartsGetData', 'MainController::ebikepartsGetData');
$routes->get('/ebikecategGetData', 'EbikeController::ebikecategGetData');
$routes->post('/categsave', 'EbikeController::categsave');
$routes->post('delt', 'EbikeController::delt');
$routes->post('/saveinvoice', 'InvoiceController::saveinvoice');
$routes->post('/saveinvoicep', 'InvoiceController::saveinvoicep');
$routes->get('/getInvoice', 'InvoiceController::getInvoice');
$routes->get('/getCategory', 'InvoiceController::getCategory');
$routes->get('/generatePdf', 'InvoiceController::generatePdf');
$routes->get('/api/sales/(:any)', 'Home::getSales/$1');
$routes->match(['get', 'post'], '/api/isales', 'Home::isales');
$routes->match(['get', 'post'], '/api/setsales/(:any)', 'Home::setsales/$1');
$routes->match(['get', 'post'], '/api/getProducts', 'Home::getProducts');
$routes->match(['get', 'post'], '/api/updateQuantity', 'Home::updateQuantity');
$routes->match(['get', 'post'], '/api/updateVoid', 'Home::updateVoid');
$routes->match(['get', 'post'], '/api/audit/(:any)', 'Home::audit/$1');
$routes->match(['get', 'post'], '/api/newproduct', 'Home::newproduct');
$routes->put('api/updateproduct/(:num)', 'Home::updateProduct/$1');
