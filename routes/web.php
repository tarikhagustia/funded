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

    Route::prefix('/members')->group(function(){
        Route::get('/af-member', [\App\Http\Controllers\Af\AfMemberController::class, 'index'])->name('af.af-member');
        Route::get('/treeview', [\App\Http\Controllers\Af\TreeviewController::class, 'index'])->name('af.treeview');
    });

    Route::prefix('/commissions')->group(function(){
        Route::get('/realtime-commissions', [\App\Http\Controllers\Af\RealtimeCommissionController::class, 'index'])->name('comm.realtime');
    });

    Route::prefix('/costs-operations')->group(function(){
        Route::get('/approval', [\App\Http\Controllers\Af\CostsOperationController::class, 'approval'])->name('costs-operation.approval');
        Route::get('/approval/create', [\App\Http\Controllers\Af\CostsOperationController::class, 'create'])->name('costs-operation.approval.create');
        
        Route::get('/request', [\App\Http\Controllers\Af\CostsOperationController::class, 'request'])->name('costs-operation.request');
        Route::get('/request/create', [\App\Http\Controllers\Af\CostsOperationController::class, 'create'])->name('costs-operation.request.create');
        
        Route::get('/{model}/edit', [\App\Http\Controllers\Af\CostsOperationController::class, 'edit'])->name('costs-operation.edit');
        Route::get('/{model}/view', [\App\Http\Controllers\Af\CostsOperationController::class, 'view'])->name('costs-operation.view');
        Route::post('/store', [\App\Http\Controllers\Af\CostsOperationController::class, 'store'])->name('costs-operation.store');
        Route::put('{model}', [\App\Http\Controllers\Af\CostsOperationController::class, 'update'])->name('costs-operation.update');
        Route::post('{model}/update-status', [\App\Http\Controllers\Af\CostsOperationController::class, 'updateStatus'])->name('costs-operation.update.status');
        Route::delete('{model}', [\App\Http\Controllers\Af\CostsOperationController::class, 'destroy'])->name('costs-operation.destroy');
    });
});

require __DIR__.'/admin.php';
