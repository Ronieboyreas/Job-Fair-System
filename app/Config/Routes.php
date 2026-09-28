<?php

use App\Controllers\AuthController;
use App\Controllers\ApplicationController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\CalendarController;

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
$routes->get('admin/dashboard', 'DashboardController::index', ['filter' => 'adminAuth']);

// Job Fair Applications Routes
$routes->get('applications', 'ApplicationController::index', ['filter' => 'adminAuth']);

// Grouped Job Fair Application Routes
$routes->group('applications', function($routes) {
    $routes->get('create', 'ApplicationController::create');
    $routes->post('store', 'ApplicationController::store');
    $routes->post('update/(:num)', [ApplicationController::class, 'update/$1']);
    $routes->get('delete/(:num)', [ApplicationController::class, 'delete/$1']);
});

// User Management Routes
$routes->get('admin/account', 'UserController::index', ['filter' => 'adminAuth']);
$routes->post('account/store', [UserController::class, 'store']);
$routes->post('account/update/(:num)', 'UserController::update/$1');
$routes->get('account/delete/(:num)', 'UserController::delete/$1');

// User/Staff Dashboard Route
$routes->get('user/dashboard', 'UserDashboard::index');
$routes->get('user/application', 'UserDashboard::apply');

// User / Staff / Admin Calendar Routes
$routes->get('user/calendar', [CalendarController::class, 'index']);
$routes->get('user/calendar/fetch', [CalendarController::class, 'fetchEvents']);
$routes->post('user/calendar/update', [CalendarController::class, 'updateDate']);