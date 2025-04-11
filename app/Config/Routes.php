<?php

use App\Controllers\DoctorCategoryController;
use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', [], function ($routes) {
    $routes->get('users', [UserController::class, 'index']);
    $routes->match(['get', 'post'], 'users/patient/create', [UserController::class, 'createPatient']);
    $routes->match(['get', 'put'], 'users/patient/update/(:num)', [UserController::class, 'updatePatient']);
    $routes->delete('users/patient/delete/(:num)', [UserController::class, 'deletePatient/$1']);

    $routes->match(['get', 'post'], 'users/doctor/create', [UserController::class, 'createDoctor']);
    $routes->match(['get', 'put'], 'users/doctor/update/(:num)', [UserController::class, 'updateDoctor']);
    $routes->delete('users/doctor/delete/(:num)', [UserController::class, 'deleteDoctor/$1']);

    $routes->get('doctor-category', [DoctorCategoryController::class, 'index']);
    $routes->match(['get', 'post'], 'doctor-category/create', [DoctorCategoryController::class, 'create']);
    $routes->match(['get', 'put'], 'doctor-category/update/(:num)', [DoctorCategoryController::class, 'update']);
    $routes->delete('doctor-category/delete/(:num)', [DoctorCategoryController::class, 'delete/$1']);
});
