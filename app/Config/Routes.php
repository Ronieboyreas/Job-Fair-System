<?php

use App\Controllers\AuthController;
use App\Controllers\ApplicationController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\CalendarController;
use App\Controllers\AccountSettingsController;
use App\Controllers\HomeController;
use App\Controllers\UserDashboard;

// ==========================================
// Public Routes
// ==========================================
$routes->get('/', [HomeController::class, 'index']);
$routes->get('index', [HomeController::class, 'index']);
$routes->get('about', [HomeController::class, 'about']);
$routes->get('contact', [HomeController::class, 'contact']);

// ==========================================
// Public Authentication Routes
// ==========================================
$routes->get('register', [AuthController::class, 'register']);
$routes->post('register', [AuthController::class, 'processRegister']);

$routes->get('login', [AuthController::class, 'login']);
$routes->post('login', [AuthController::class, 'processLogin']);

$routes->get('logout', [AuthController::class, 'logout']);

// ==========================================
// Protected Routes: ANY Logged-In User
// ==========================================
$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // User/Staff Dashboard Routes
    $routes->get('user/dashboard', [UserDashboard::class, 'index']);
    $routes->get('user/application', [UserDashboard::class, 'apply']);

    // User / Staff / Admin Calendar Routes
    $routes->get('user/calendar', [CalendarController::class, 'index']);
    $routes->get('user/calendar/fetch', [CalendarController::class, 'fetchEvents']);
    $routes->post('user/calendar/update', [CalendarController::class, 'updateDate']);

    // Account Settings Routes (Available to all logged-in users)
    $routes->group('account_settings', static function ($routes) {
        $routes->get('/', [AccountSettingsController::class, 'index']);
        $routes->get('index', [AccountSettingsController::class, 'index']);
        $routes->post('update-profile', [AccountSettingsController::class, 'updateProfile']);
        $routes->post('change-password', [AccountSettingsController::class, 'changePassword']);
    });

});

// ==========================================
// Protected Routes: ADMINISTRATORS ONLY
// ==========================================
$routes->group('', ['filter' => 'adminAuth'], static function ($routes) {

    // Admin Dashboard
    $routes->get('admin/dashboard', [DashboardController::class, 'index']);

    // Job Fair Applications Management
    $routes->get('applications', [ApplicationController::class, 'index']);
    $routes->group('applications', static function ($routes) {
        $routes->get('create', [ApplicationController::class, 'create']);
        $routes->post('store', [ApplicationController::class, 'store']);
        $routes->post('update/(:num)', [ApplicationController::class, 'update/$1']);
        $routes->get('delete/(:num)', [ApplicationController::class, 'delete/$1']);
    });

    // Admin User Management Routes
    $routes->get('admin/account', [UserController::class, 'index']);
    $routes->post('account/store', [UserController::class, 'store']);
    $routes->post('account/update/(:num)', [UserController::class, 'update/$1']);
    $routes->get('account/delete/(:num)', [UserController::class, 'delete/$1']);

});