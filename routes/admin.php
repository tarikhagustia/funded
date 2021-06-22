<?php

use App\Http\Controllers\Console\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix("/console")->name("console.")->group(function (){

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
         ->middleware('guest')
         ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
         ->middleware('guest')
         ->name("login-post");

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
         ->middleware('auth')
         ->name('logout');

    // Authenticated Routes
    Route::middleware("auth:admin")->group(function (){

        Route::get("/", [\App\Http\Controllers\Console\DashboardController::class, 'index']);
    });

});
