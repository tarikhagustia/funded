<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Af\Auth\AuthenticatedSessionController;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
     ->middleware('guest')
     ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
     ->middleware('guest')
     ->name("login-post");

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
     ->middleware('auth:af')
     ->name('logout');

Route::middleware('auth:af')->group(function(){
    Route::get('/', [\App\Http\Controllers\Af\DashboardController::class, 'index']);
    Route::get('/dashboard', [\App\Http\Controllers\Af\DashboardController::class, 'index']);
});

require __DIR__.'/admin.php';
