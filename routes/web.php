<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\KanibalController;
use App\Http\Controllers\KembaliController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceDoneController;
use App\Http\Controllers\ServicePendingController;

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

Route::get('/', function () {
    return view('auth.login');
});

//Lupa Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('forgot.password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->middleware('guest')->name('password-reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('update.password');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

Route::resource('/product', ProductController::class);


//Monitor
Route::get('/monitor', [MonitorController::class, 'index'])->middleware('auth');
Route::get('/monitor/total', [MonitorController::class, 'total'])->middleware('auth');

//PINJAM
Route::get('/export-pinjam', [PinjamController::class, 'exportPinjam'])->middleware('auth')->name('export-pinjam');
Route::get('/pinjam/search', [PinjamController::class, 'search'])->middleware('auth')->name('search.index');

Route::resource('/pinjam', PinjamController::class)->middleware('auth')->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/pinjam/{id}/edit', [PinjamController::class, 'edit'])->middleware('auth')->name('users.edit');
Route::put('/pinjam/{id}', [PinjamController::class, 'update'])->middleware('auth')->name('users.update');
Route::get('/pinjam/{id}', [PinjamController::class, 'show'])->middleware('auth')->name('users.show');
Route::delete('/pinjam/{id}', [PinjamController::class, 'destroy'])->middleware('auth')->name('users.destroy');

//KEMBALI
Route::get('/export-kembali', [KembaliController::class, 'exportKembali'])->middleware('auth')->name('export-kembali');

Route::resource('/kembali', KembaliController::class)->middleware('auth')->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/kembali/{id}/edit', [KembaliController::class, 'edit'])->middleware('auth')->name('kembali.edit');
Route::put('/kembali/{id}', [KembaliController::class, 'update'])->middleware('auth')->name('kembali.update');
Route::get('/kembali/{id}', [KembaliController::class, 'show'])->middleware('auth')->name('kembali.show');
Route::delete('/kembali/{id}', [KembaliController::class, 'destroy'])->middleware('auth')->name('kembali.destroy');

//SERVICEDONE
Route::get('/servicedone/search', [ServiceDoneController::class, 'search'])->middleware('auth')->name('search.servicedone');
Route::resource('/servicedone', ServiceDoneController::class)->middleware('auth')->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/servicedone/{id}/edit', [ServiceDoneController::class, 'edit'])->middleware('auth')->name('servicedone.edit');
Route::put('/servicedone/{id}', [ServiceDoneController::class, 'update'])->middleware('auth')->name('servicedone.update');
Route::get('/servicedone/{id}', [ServiceDoneController::class, 'show'])->middleware('auth')->name('servicedone.show');
Route::delete('/servicedone/{id}', [ServiceDoneController::class, 'destroy'])->middleware('auth')->name('servicedone.destroy');
Route::get('/export-servicedone', [ServiceDoneController::class, 'exportServiceDone'])->middleware('auth')->name('export-servicedone');

//SERVICE PENDING
Route::get('/servicepending/search', [ServicePendingController::class, 'search'])->middleware('auth')->name('search.servicepending');
Route::resource('/servicepending', ServicePendingController::class)->middleware('auth')->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/servicepending/{id}/edit', [ServicePendingController::class, 'edit'])->middleware('auth')->name('servicepending.edit');
Route::put('/servicepending/{id}', [ServicePendingController::class, 'update'])->middleware('auth')->name('servicepending.update');
Route::get('/servicepending/{id}', [ServicePendingController::class, 'show'])->middleware('auth')->name('servicepending.show');
Route::delete('/servicepending/{id}', [ServicePendingController::class, 'destroy'])->middleware('auth')->name('servicepending.destroy');
Route::get('/export-servicepending', [ServicePendingController::class, 'exportServicePending'])->middleware('auth')->name('export-servicepending');

Route::get('/servicepending/finish/{id}', [ServicePendingController::class, 'finish'])->middleware('auth');

//KANIBAL
Route::get('/kanibal/search', [KanibalController::class, 'search'])->name('search.kanibal')->middleware('auth');
Route::resource('/kanibal', KanibalController::class)->middleware('auth')->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/kanibal/{id}/edit', [KanibalController::class, 'edit'])->middleware('auth')->name('kanibal.edit');
Route::put('/kanibal/{id}', [KanibalController::class, 'update'])->middleware('auth')->name('kanibal.update');
Route::get('/kanibal/{id}', [KanibalController::class, 'show'])->middleware('auth')->name('kanibal.show');
Route::delete('/kanibal/{id}', [KanibalController::class, 'destroy'])->middleware('auth')->name('kanibal.destroy');
Route::get('/export-kanibal', [KanibalController::class, 'exportKanibal'])->middleware('auth')->name('export-kanibal');

Route::get('/kanibal/finish/{id}', [KanibalController::class, 'finish'])->middleware('auth');
