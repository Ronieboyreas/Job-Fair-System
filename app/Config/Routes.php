<?php

use App\Controllers\AuthController;
use App\Controllers\ApplicationController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;

// Redirect root URL to Login
$routes->get('/', static function () {
    return redirect()->to('/login');
});

// Authentication Routes
$routes->get('register', [AuthController::class, 'register']);
$routes->post('register', [AuthController::class, 'processRegister']);

$routes->get('login', [AuthController::class, 'login']);
$routes->post('login', [AuthController::class, 'processLogin']);

$routes->get('logout', [AuthController::class, 'logout']);

// Dashboard Route (Points directly to Controller)
$routes->get('admin/dashboard', [DashboardController::class, 'index']);

// Job Fair Applications Routes
$routes->get('applications', [ApplicationController::class, 'index']);
$routes->post('applications/store', [ApplicationController::class, 'create']);
$routes->post('applications/update/(:num)', [ApplicationController::class, 'update/$1']);
$routes->get('applications/delete/(:num)', [ApplicationController::class, 'delete/$1']);

// User Management Routes
$routes->get('admin/account', [UserController::class, 'index']);
$routes->post('account/store', [UserController::class, 'store']);
$routes->post('account/update/(:num)', 'UserController::update/$1');
$routes->get('account/delete/(:num)', 'UserController::delete/$1');
