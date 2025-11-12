<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\BankController;
use App\Http\Controllers\PosController;
>>>>>>> Stashed changes

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
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

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