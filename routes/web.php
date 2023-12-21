<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReparationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\InspectionListController;

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

Route::group(['middleware' => ['web']], function () { 
    Route::get('/authentication/login', [AuthenticationController::class, 'login'])->name('authentication.login.form');
    Route::post('/authentication/process-login', [AuthenticationController::class, 'processLogin'])->name('authentication.login.process');
    Route::get('/authentication/register', [AuthenticationController::class, 'register'])->name('authentication.register.form');
    Route::post('/authentication/process-register', [AuthenticationController::class, 'processRegister'])->name('authentication.register.process');
    Route::get('/authentication/verification', [AuthenticationController::class, 'verification'])->name('authentication.verification.form');
    Route::post('/authentication/process-verification', [AuthenticationController::class, 'processVerification'])->name('authentication.verification.process');
    Route::get('/authentication/process-logout', [AuthenticationController::class, 'processLogout'])->name('authentication.logout.process');
    Route::get('/user/login', [UserController::class, 'login'])->name('user.login.form');
    Route::post('/user/process-login', [UserController::class, 'processLogin'])->name('user.login.process');
    Route::get('/user/process-logout', [UserController::class, 'processLogout'])->name('user.logout.process');
});

Route::middleware('auth:ms_users')->group(function () {
   
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/process-create', [UserController::class, 'processCreate'])->name('user.create.process');
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete.form');
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
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
    Route::post('/vehicle/{id}/update', [VehicleController::class, 'update'])->name('Vehicle.Update');
    Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy'])->name('Vehicle.Destroy');
});

// Booking (customer)
Route::middleware(['auth:ms_customers'])->group(function () {
    Route::get('/booking', [BookingController::class, 'Index'])->name('booking.Index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.Create');
    Route::post('/booking/create', [BookingController::class, 'store'])->name('booking.Store');

    Route::get('/booking/fast', [BookingController::class, 'fast'])->name('booking.fast');
    Route::post('/booking/fast', [BookingController::class, 'faststore'])->name('booking.faststore');
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
    Route::post('/pending/stop/{id_pending}', [PendingController::class, 'stoppending'])->name('Pending.stop');

    Route::get('/temuan/{id_booking}/{id_vehicle}', [ReparationController::class, 'inden'])->name('inden.form');
    Route::post('/pending', [ReparationController::class, 'indenstore'])->name('inden.store');
});

//Reparation
Route::middleware('auth:ms_users')->group(function () {
    Route::get('reparation/index/{idBooking}', [ReparationController::class, 'index'])->name('reparation.index');
    Route::get('reparation/form-plan/{idBooking}', [ReparationController::class, 'formPlan'])->name('reparation.form-plan');
    Route::post('reparation/process-form-plan', [ReparationController::class, 'processFormPlan'])->name('reparation.process-form-plan');
    Route::get('reparation/form-decision/{idBooking}', [ReparationController::class, 'formDecision'])->name('reparation.form-decision');
    Route::post('reparation/post-form-decision', [ReparationController::class, 'postFormDecision'])->name('reparation.post-form-decision');
    Route::get('reparation/form-finish-execution/{idBooking}', [ReparationController::class, 'formFinishExecution'])->name('reparation.form-finish-execution');
    Route::post('reparation/post-form-finish-execution', [ReparationController::class, 'postFormFinishExecution'])->name('reparation.post-form-finish-execution');
    Route::get('reparation/form-control/{idBooking}', [ReparationController::class, 'formControl'])->name('reparation.form-control');
    Route::post('reparation/post-form-control', [ReparationController::class, 'postFormControl'])->name('reparation.post-form-control');
    Route::get('reparation/form-evaluation/{idBooking}', [ReparationController::class, 'formEvaluation'])->name('reparation.form-evaluation');
    Route::post('reparation/post-form-evaluation', [ReparationController::class, 'postFormEvaluation'])->name('reparation.post-form-evaluation');
    Route::get('reparation/form-special-handling/{idBooking}', [ReparationController::class, 'formSpecialHandling'])->name('reparation.form-special-handling');
    Route::post('reparation/post-form-special-handling', [ReparationController::class, 'postFormSpecialHandling'])->name('reparation.post-form-special-handling');
    Route::get('/reparation/form-start-service/{idBooking}', [ReparationController::class, 'formStartService'])->name('reparation.form-start-service');
    Route::post('reparation/post-form-start-service', [ReparationController::class, 'postFormStartService'])->name('reparation.post-form-start-service');
});

//Inspection list
Route::middleware('auth:ms_users')->group(function () {
    Route::get('inspection_list/index/{idBooking}', [InspectionListController::class, 'index'])->name('inspection_list.index');
    Route::post('inspection_list/create', [InspectionListController::class, 'create'])->name('inspection_list.create');
});