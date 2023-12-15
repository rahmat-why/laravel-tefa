<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\RaparationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web"s middleware group. Now create something great!
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

//home
Route::middleware('auth:ms_customers')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.form');
    Route::get('/authentication/process-logout', [AuthenticationController::class, 'processLogout'])->name('authentication.logout.process');
});

// Vehicle
Route::middleware(['auth:ms_customers'])->group(function () {
    Route::get('/vehicle', [VehicleController::class, 'Index'])->name('Vehicle.Index');
    Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('Vehicle.Create');
    Route::post('/vehicle/create', [VehicleController::class, 'store'])->name('Vehicle.Store');
    Route::get('/vehicle/{id}/edit', [VehicleController::class, 'edit'])->name('Vehicle.Edit');
    Route::put('/vehicle/{id}', [VehicleController::class, 'update'])->name('Vehicle.Update');
    Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy'])->name('Vehicle.Destroy');
});

// Booking (customer)
Route::middleware(['auth:ms_customers'])->group(function () {
    Route::get('/booking', [BookingController::class, 'Index'])->name('booking.Index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.Create');
    Route::post('/booking/create', [BookingController::class, 'store'])->name('booking.Store');

    Route::get('/booking/createe', [BookingController::class, 'fast'])->name('booking.fast');
    Route::post('/booking/createe', [BookingController::class, 'faststore'])->name('booking.faststore');
});

//Booking (user/sa)
Route::middleware('auth:ms_users')->group(function () {
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history.form');
    Route::get('/vehicles/{id}/history', [VehicleController::class, 'showHistory'])->name('vehicles.history');
    Route::get('/booking/progres', [BookingController::class, 'progress'])->name('booking.progres.form');
    Route::get('/booking/report', [BookingController::class, 'report'])->name('booking.report.form');

    //report excel/pdf
    Route::get('/booking/{id}/pdf', [BookingController::class, 'pdf'])->name('booking.invoice');

    Route::get('/booking/export', [BookingController::class, 'export'])->name('booking.export');///pdffffffffffffffffffffffffff
    Route::get('/booking/pdf', [BookingController::class, 'dowload_pdf'])->name('booking.pdf');
});

//Pending
Route::middleware('auth:ms_users')->group(function () {
    Route::post('/pending/start', [PendingController::class, 'startpending'])->name('Pending.start');
    Route::get('/pending/{id_booking}', [PendingController::class, 'index'])->name('Pending.index');
    Route::put('/pending/stop/{id_pending}', [PendingController::class, 'stoppending'])->name('Pending.stop');


    Route::get('/temuan/{id_booking}/{id_vehicle}', [RaparationController::class, 'inden'])->name('inden.form');
    Route::post('/pending', [RaparationController::class, 'indenstore'])->name('inden.store');



Route::get('/reparation/formindent/{id_booking}', [RaparationController::class, 'formIndent'])->name('reparation.formindent');
Route::put('/reparation/formindent/{id_booking}', [RaparationController::class, 'formIndentPost'])->name('reparation.formindent.post');

  
});
