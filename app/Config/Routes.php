<?php

use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', [], function ($routes) {
    $routes->get('users', [UserController::class, 'index']);
    $routes->match(['get', 'post'], 'users/doctor/create', [UserController::class, 'createDoctor']);
    $routes->match(['get', 'post'], 'users/patient/create', [UserController::class, 'createPatient']);
});
