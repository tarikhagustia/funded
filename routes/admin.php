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
         ->middleware('auth:admin')
         ->name('logout');

    // Authenticated Routes
    Route::middleware(["auth:admin", "console"])->group(function (){

        Route::get("/", [\App\Http\Controllers\Console\DashboardController::class, 'index']);

          Route::prefix('clients')->name("clients.")->group(function(){
               Route::get('/',[\App\Http\Controllers\Console\ClientController::class, 'index'])->name('index');
               Route::get('/show/{client}',[\App\Http\Controllers\Console\ClientController::class, 'show'])->name('view');
          });

          Route::prefix('trading_accounts')->name("trading_accounts.")->group(function(){
               Route::get('/',[\App\Http\Controllers\Console\TradingAccountController::class, 'index'])->name('index');
               Route::get('/show/{account}',[\App\Http\Controllers\Console\TradingAccountController::class, 'show'])->name('view');
          });

        Route::get("/", [\App\Http\Controllers\Console\DashboardController::class, 'index']);

        // User Management
        Route::resource('users', \App\Http\Controllers\Console\UserController::class);

        // AF Management
        Route::resource('affiliates', \App\Http\Controllers\Console\AfController::class);

        // Setting Route
        Route::resource('account-types', \App\Http\Controllers\Console\Setting\AccountTypeController::class);

        // Commission Route
        Route::resource('reports/commissions', \App\Http\Controllers\Console\Report\CommissionController::class);
    });

});
