<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('')->group(function () {
    Route::get('/authentication/login', [AuthenticationController::class, 'login'])->name('authentication.login.form');
    Route::post('/authentication/process-login', [AuthenticationController::class, 'processLogin'])->name('authentication.login.process');
    Route::get('/authentication/register', [AuthenticationController::class, 'register'])->name('authentication.register.form');
    Route::post('/authentication/process-register', [AuthenticationController::class, 'processRegister'])->name('authentication.register.process');
    Route::get('/authentication/verification', [AuthenticationController::class, 'verification'])->name('authentication.verification.form');
    Route::post('/authentication/process-verification', [AuthenticationController::class, 'processVerification'])->name('authentication.verification.process');
    Route::get('/authentication/process-logout', [AuthenticationController::class, 'processLogout'])->name('authentication.logout.process');
});

Route::prefix('')->group(function () {
    Route::get('/user/login', [UserController::class, 'login'])->name('user.login.form');
    Route::post('/user/process-login', [UserController::class, 'processLogin'])->name('user.login.process');
    Route::get('/user/process-logout', [UserController::class, 'processLogout'])->name('user.logout.process');
});

Route::middleware('auth:ms_users')->group(function () {
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history.form');
});

Route::middleware('auth:ms_customers')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.form');
    Route::get('/authentication/process-logout', [AuthenticationController::class, 'processLogout'])->name('authentication.logout.process');
});