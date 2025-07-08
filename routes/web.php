<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return Inertia::render('Register');
});

Route::get('/Home', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/Login', function () {
    return Inertia::render('Login');
});

// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
