<?php

use App\Controllers\AuthController;

// Redirect root URL (http://localhost:8080) directly to Login
$routes->get('/', static function () {
    return redirect()->to('/login');
});

// Authentication Routes
$routes->get('register', [AuthController::class, 'register']);
$routes->post('register', [AuthController::class, 'processRegister']);

$routes->get('login', [AuthController::class, 'login']);
$routes->post('login', [AuthController::class, 'processLogin']);

$routes->get('logout', [AuthController::class, 'logout']);

// Dashboard Route (Protected)
$routes->get('dashboard', function () {
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/login')->with('error', 'Please log in first.');
    }
    return view('dashboard');
});