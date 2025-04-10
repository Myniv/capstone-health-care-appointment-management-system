<?php

use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', [], function ($routes) {
    $routes->get('users', [UserController::class, 'index']);
    $routes->match(['get', 'post'], 'users/patient/create', [UserController::class, 'createPatient']);
    $routes->delete('users/patient/delete/(:num)', [UserController::class, 'deletePatient/$1']);
    
    $routes->match(['get', 'post'], 'users/doctor/create', [UserController::class, 'createDoctor']);
    $routes->delete('users/doctor/delete/(:num)', [UserController::class, 'deleteDoctor/$1']);
});
