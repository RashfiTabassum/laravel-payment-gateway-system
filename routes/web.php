<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TransactionController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');


    Route::middleware('userType:1')->group(function () {

        // Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::resource('admins', AdminController::class)->except(['show'])->names('admins');
        Route::resource('merchants', MerchantController::class)->names('merchants');
        Route::get('banks', [BankController::class, 'index'])->name('banks.index');
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('banks', BankController::class);
        });


        Route::prefix('admin/banks')->name('admin.banks.')->group(function () {
            Route::get('/', [BankController::class, 'index'])->name('index');
            Route::get('/create', [BankController::class, 'create'])->name('create');
            Route::post('/', [BankController::class, 'store'])->name('store');
            Route::get('/{bank}', [BankController::class, 'show'])->name('show');
            Route::get('/{bank}/edit', [BankController::class, 'edit'])->name('edit');
            Route::put('/{bank}', [BankController::class, 'update'])->name('update');
            Route::delete('/{bank}', [BankController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('currencies')->name('currencies.')->group(function () {
            Route::get('/', [CurrencyController::class, 'index'])->name('index');
            Route::get('/create', [CurrencyController::class, 'create'])->name('create');
            Route::post('/', [CurrencyController::class, 'store'])->name('store');
            Route::get('/{currency}', [CurrencyController::class, 'show'])->name('show');
            Route::get('/{currency}/edit', [CurrencyController::class, 'edit'])->name('edit');
            Route::put('/{currency}', [CurrencyController::class, 'update'])->name('update');
            Route::delete('/{currency}', [CurrencyController::class, 'destroy'])->name('destroy');
        });

        // POS management for admins
        Route::get('pos', [PosController::class, 'index'])->name('pos.index');
        Route::get('pos/create', [PosController::class, 'create'])->name('pos.create');
        Route::post('pos', [PosController::class, 'store'])->name('pos.store');
        Route::get('pos/{pos}/edit', [PosController::class, 'edit'])->name('pos.edit');
        Route::put('pos/{pos}', [PosController::class, 'update'])->name('pos.update');
        Route::delete('pos/{pos}', [PosController::class, 'destroy'])->name('pos.destroy');

    });


    Route::middleware('userType:2')->prefix('merchant')->as('merchant.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'merchantDashboard'])->name('dashboard');

        Route::get('profile', [MerchantController::class, 'profile'])->name('profile');

        // ✅ Now your resource routes will be named 'merchant.transactions.*'
        Route::resource('transactions', TransactionController::class)
            ->only(['index', 'show']);

        Route::patch('transactions/{transaction}/update-status', [TransactionController::class, 'updateStatus'])
            ->name('transactions.updateStatus');
            

    });  
    


});



