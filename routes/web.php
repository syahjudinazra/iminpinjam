<?php

use App\Http\Controllers\MonitorController;
use App\Http\Controllers\KanibalController;
use App\Http\Controllers\KembaliController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceDoneController;
use App\Http\Controllers\ServicePendingController;
use App\Models\ServicePending;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

Route::resource('/product', ProductController::class);


//Monitor
Route::get('/monitor', [MonitorController::class, 'index']);
Route::get('/monitor/total', [MonitorController::class, 'total']);

//PINJAM
Route::get('/export-pinjam', [PinjamController::class, 'exportPinjam'])->name('export-pinjam');
Route::get('/pinjam/search', [PinjamController::class, 'search'])->name('search.index');

Route::resource('/pinjam', PinjamController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/pinjam/{id}/edit', [PinjamController::class, 'edit'])->name('users.edit');
Route::put('/pinjam/{id}', [PinjamController::class, 'update'])->name('users.update');
Route::get('/pinjam/{id}', [PinjamController::class, 'show'])->name('users.show');
Route::delete('/pinjam/{id}', [PinjamController::class, 'destroy'])->name('users.destroy');

//KEMBALI
Route::get('/export-kembali', [KembaliController::class, 'exportKembali'])->name('export-kembali');

Route::resource('/kembali', KembaliController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/kembali/{id}/edit', [KembaliController::class, 'edit'])->name('kembali.edit');
Route::put('/kembali/{id}', [KembaliController::class, 'update'])->name('kembali.update');
Route::get('/kembali/{id}', [KembaliController::class, 'show'])->name('kembali.show');
Route::delete('/kembali/{id}', [KembaliController::class, 'destroy'])->name('kembali.destroy');

//SERVICEDONE
Route::get('/servicedone/search', [ServiceDoneController::class, 'search'])->name('search.servicedone');
Route::resource('/servicedone', ServiceDoneController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/servicedone/{id}/edit', [ServiceDoneController::class, 'edit'])->name('servicedone.edit');
Route::put('/servicedone/{id}', [ServiceDoneController::class, 'update'])->name('servicedone.update');
Route::get('/servicedone/{id}', [ServiceDoneController::class, 'show'])->name('servicedone.show');
Route::delete('/servicedone/{id}', [ServiceDoneController::class, 'destroy'])->name('servicedone.destroy');
Route::get('/export-servicedone', [ServiceDoneController::class, 'exportServiceDone'])->name('export-servicedone');

//SERVICE PENDING
Route::resource('/servicepending', ServicePendingController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/servicepending/{id}/edit', [ServicePendingController::class, 'edit'])->name('servicepending.edit');
Route::put('/servicepending/{id}', [ServicePendingController::class, 'update'])->name('servicepending.update');
Route::get('/servicepending/{id}', [ServicePendingController::class, 'show'])->name('servicepending.show');
Route::delete('/servicepending/{id}', [ServicePendingController::class, 'destroy'])->name('servicepending.destroy');
Route::get('/export-servicepending', [ServicePendingController::class, 'exportServicePending'])->name('export-servicepending');

Route::get('/servicepending/finish/{id}', [ServicePendingController::class, 'finish']);

//KANIBAL
Route::resource('/kanibal', KanibalController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/kanibal/{id}/edit', [KanibalController::class, 'edit'])->name('kanibal.edit');
Route::put('/kanibal/{id}', [KanibalController::class, 'update'])->name('kanibal.update');
Route::get('/kanibal/{id}', [KanibalController::class, 'show'])->name('kanibal.show');
Route::delete('/kanibal/{id}', [KanibalController::class, 'destroy'])->name('kanibal.destroy');
Route::get('/export-kanibal', [KanibalController::class, 'exportKanibal'])->name('export-kanibal');

Route::get('/kanibal/finish/{id}', [KanibalController::class, 'finish']);
