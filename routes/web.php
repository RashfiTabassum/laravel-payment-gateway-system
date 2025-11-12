<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BankController;
<<<<<<< HEAD
use App\Http\Controllers\PosController;



=======
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\AdminController;
>>>>>>> 99a84e2d773dbda1a8c057152fec61f1e44b4a94
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('login',   [AuthController::class, 'login'])->name('login.post');

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register',[AuthController::class, 'register'])->name('register.post');
});



Route::middleware('auth')->group(function () {
    // Banks
    Route::get('banks', [BankController::class, 'index'])->name('banks.index');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
<<<<<<< HEAD

});

Route::middleware('auth')->group(function () {
    // POS
    Route::get('pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('pos/create', [PosController::class, 'create'])->name('pos.create');
    Route::post('pos', [PosController::class, 'store'])->name('pos.store');
    Route::get('pos/{pos}/edit', [PosController::class, 'edit'])->name('pos.edit');
    Route::put('pos/{pos}', [PosController::class, 'update'])->name('pos.update');
    Route::delete('pos/{pos}', [PosController::class, 'destroy'])->name('pos.destroy');


});
=======
});


// Currencies CRUD (all routes protected by auth)
// Route::middleware('auth')->group(function () {
//     Route::get('currencies', [CurrencyController::class, 'index'])->name('currencies.index');
//     Route::get('currencies/create', [CurrencyController::class, 'create'])->name('currencies.create');
//     Route::post('currencies', [CurrencyController::class, 'store'])->name('currencies.store');
//     //Route::get('currencies/{currency}', [CurrencyController::class, 'show'])->name('currencies.show');
//     Route::get('currencies/{currency}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
//     Route::put('currencies/{currency}', [CurrencyController::class, 'update'])->name('currencies.update');
//     Route::delete('currencies/{currency}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');
// });
Route::prefix('currencies')->name('currencies.')->group(function () {
    Route::get('/', [CurrencyController::class, 'index'])->name('index');
    Route::get('/create', [CurrencyController::class, 'create'])->name('create');
    Route::post('/', [CurrencyController::class, 'store'])->name('store');
    Route::get('/{currency}', [CurrencyController::class, 'show'])->name('show');
    Route::get('/{currency}/edit', [CurrencyController::class, 'edit'])->name('edit');
    Route::put('/{currency}', [CurrencyController::class, 'update'])->name('update');
    Route::delete('/{currency}', [CurrencyController::class, 'destroy'])->name('destroy');
});


// Route::resource('admins', AdminController::class)
//         ->names('admins')
//         ->except(['show']);
// Route::get('admins/{admin}', [AdminController::class, 'show'])->name('admins.show')->middleware('auth');

>>>>>>> 99a84e2d773dbda1a8c057152fec61f1e44b4a94
