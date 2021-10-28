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

          // Route::prefix('affiliates')->name("affiliates.")->group(function(){
          //      Route::get('/',[\App\Http\Controllers\Console\AffiliateController::class, 'index'])->name('index');
          //      Route::get('/show/{affiliate}',[\App\Http\Controllers\Console\AffiliateController::class, 'show'])->name('view');
          // });

          Route::prefix('trading_accounts')->name("trading_accounts.")->group(function(){
               Route::get('/',[\App\Http\Controllers\Console\TradingAccountController::class, 'index'])->name('index');
               Route::get('/show/{account}',[\App\Http\Controllers\Console\TradingAccountController::class, 'show'])->name('view');
          });

        Route::get("/", [\App\Http\Controllers\Console\DashboardController::class, 'index']);

        // User Management
        Route::resource('users', \App\Http\Controllers\Console\UserController::class);

        // Role Management
        Route::resource('/roles', \App\Http\Controllers\Console\RoleController::class)->except([
            'show'
        ]);

        // AF Management
        Route::resource('affiliates', \App\Http\Controllers\Console\AfController::class);

        // Setting Route
        Route::resource('account-types', \App\Http\Controllers\Console\Setting\AccountTypeController::class);

        // Commission Route
        Route::resource('reports/commissions', \App\Http\Controllers\Console\Report\CommissionController::class);

        // Withdrawal Route
        Route::resource('reports/withdrawals', \App\Http\Controllers\Console\Report\WithdrawalController::class)->only('index');

        Route::resource('reports/closed-order-by-lq', \App\Http\Controllers\Console\Report\ClosedOrderController::class)->only('index');

        Route::prefix('reports/statistics')->name('reports.statistics.')->group(function(){
            Route::get('/', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'index'])->name('index');
            Route::get('/symbols', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'symbol'])->name('symbol');
            Route::get('/top-commission', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'topCommission'])->name('top-commission');
            Route::get('/top-new-member', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'topNewMember'])->name('top-new-member');
            Route::get('/top-gainer', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'topGainer'])->name('top-gainer');
            Route::get('/top-looser', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'topLooser'])->name('top-looser');
            Route::get('/affiliate-commission', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'affiliateCommission'])->name('affiliate-commission');
            Route::get('/treeview', [\App\Http\Controllers\Console\Report\Statistic\StatisticController::class, 'treeViewReport'])->name('treeview');
        });
    });

});
