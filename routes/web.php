<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return Inertia::render('Register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/Home', [RecipesController::class, 'index']);
    Route::get('/Recipe/{id}/show', [RecipesController::class, 'show'])->name('recipe.show');
});


Route::get('/Login', function () {
    return Inertia::render('Login');
});

// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::post('/chatbot', [ChatbotController::class, 'sendMessage'])->name('chatbot.sendMessage');
Route::post('/chatbot-feedback', [ChatbotController::class, 'sendFeedback'])->name('chatbot.sendFeedback');

Route::post('/submit-onboarding', [App\Http\Controllers\OnboardingController::class, 'store']);

//Route::post('/confidence', [ReviewController::class, 'classifyConfidence'])->name('confidence.classify');
