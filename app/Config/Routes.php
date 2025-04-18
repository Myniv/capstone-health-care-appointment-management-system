<?php

use App\Controllers\AppointmentController;
use App\Controllers\AuthController;
use App\Controllers\DoctorCategoryController;
use App\Controllers\DoctorController;
use App\Controllers\DoctorScheduleController;
use App\Controllers\EquipmentController;
use App\Controllers\RoomController;
use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;
use Config\Roles;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', ['filter' => 'role:' . Roles::ADMIN], function ($routes) {
    $routes->get('dashboard', [UserController::class, 'dashboard']);

    $routes->get('users', [UserController::class, 'index']);
    $routes->get('users/patient/profile/(:num)', [UserController::class, 'profile/$1']);
    $routes->match(['get', 'post'], 'users/patient/create', [UserController::class, 'createPatient']);
    $routes->match(['get', 'put'], 'users/patient/update/(:num)', [UserController::class, 'updatePatient']);
    $routes->delete('users/patient/delete/(:num)', [UserController::class, 'deletePatient/$1']);

    $routes->get('users/doctor/profile/(:num)', [UserController::class, 'profile/$1']);
    $routes->match(['get', 'post'], 'users/doctor/create', [UserController::class, 'createDoctor']);
    $routes->match(['get', 'put'], 'users/doctor/update/(:num)', [UserController::class, 'updateDoctor']);
    $routes->delete('users/doctor/delete/(:num)', [UserController::class, 'deleteDoctor/$1']);

    $routes->get('doctor-category', [DoctorCategoryController::class, 'index']);
    $routes->match(['get', 'post'], 'doctor-category/create', [DoctorCategoryController::class, 'create']);
    $routes->match(['get', 'put'], 'doctor-category/update/(:num)', [DoctorCategoryController::class, 'update']);
    $routes->delete('doctor-category/delete/(:num)', [DoctorCategoryController::class, 'delete/$1']);

    $routes->get('doctor-schedule', [DoctorScheduleController::class, 'index']);
    $routes->match(['get', 'post'], 'doctor-schedule/create', [DoctorScheduleController::class, 'create']);
    $routes->match(['get', 'put'], 'doctor-schedule/update/(:num)', [DoctorScheduleController::class, 'update']);
    $routes->post('doctor-schedule/check-availability', [DoctorScheduleController::class, 'checkAvailability']);
    $routes->delete('doctor-schedule/delete/(:num)', [DoctorScheduleController::class, 'delete/$1']);

    $routes->get('equipment', [EquipmentController::class, 'index']);
    $routes->match(['get', 'post'], 'equipment/create', [EquipmentController::class, 'create']);
    $routes->match(['get', 'put'], 'equipment/update/(:num)', [EquipmentController::class, 'update']);
    $routes->delete('equipment/delete/(:num)', [EquipmentController::class, 'delete/$1']);

    $routes->get('room', [RoomController::class, 'index']);
    $routes->match(['get', 'post'], 'room/create', [RoomController::class, 'create']);
    $routes->match(['get', 'put'], 'room/update/(:num)', [RoomController::class, 'update']);
    $routes->delete('room/delete/(:num)', [RoomController::class, 'delete/$1']);
});

$routes->group('doctor', [], function ($routes) {
    $routes->get('dashboard', [DoctorController::class, 'dashboard']);
    $routes->get('absent', [DoctorController::class, 'getDoctorAbsent']);
    $routes->match(['get', 'post'], 'absent/create', [DoctorController::class, 'createDoctorAbsent']);
});

$routes->group('appointment', [], function ($routes) {
    $routes->get('', [AppointmentController::class, 'index']);
    $routes->get('create', [AppointmentController::class, 'createAppointment']);
    $routes->post('create/submit', [AppointmentController::class, 'createAppointmentSubmit']);
    $routes->get('create/form', [AppointmentController::class, 'createAppointmentForm']);
});




//Auth routes
$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Registrasi
    $routes->get('register', [AuthController::class, 'register'], ['as' => 'register']);
    $routes->post('register', [AuthController::class, 'attemptRegister']);

    // Route lain seperti login, dll
    $routes->get('login', [AuthController::class, 'login'], ['as' => 'login']);
    $routes->post('login', [AuthController::class, 'attemptLogin']);

    // //Forgot Password
    // $routes->get('forgot-password', 'AuthController::forgotPassword', ['as' => 'forgot']);
    // $routes->post('forgot-password', 'AuthController::attemptForgotPassword');

    // //Reset Password
    // $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    // $routes->post('reset-password', 'AuthController::attemptResetPassword');

    $routes->get('unauthorized', [AuthController::class, 'unauthorized']);

    $routes->get('profile-picture', [UserController::class, 'profilePicture']);
});
