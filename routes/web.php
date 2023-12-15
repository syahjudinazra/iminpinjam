<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\FirmwareController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\KanibalController;
use App\Http\Controllers\KembaliController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceDoneController;
use App\Http\Controllers\ServicePendingController;
use App\Http\Controllers\SparePartsController;

// Route::get('/', function () {
//     // return view('auth.login');
//     return view('home');
// });

//Dashboard
Route::get('/', [HomeController::class, 'index']);
Route::get('/home/total', [HomeController::class, 'total']);

//Lupa Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('forgot.password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->middleware('guest')->name('password-reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('update.password');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

Route::get('/pinjam/{id}/edit', [PinjamController::class, 'edit'])->middleware('auth')->name('users.edit');
Route::put('/pinjam/{id}', [PinjamController::class, 'update'])->middleware('auth')->name('users.update');
Route::delete('/pinjam/{id}', [PinjamController::class, 'destroy'])->middleware('auth')->name('users.destroy');
Route::get('/pinjam/{id}', [PinjamController::class, 'show'])->name('users.show');
Route::get('/generate-pdf/{id}', [PinjamController::class, 'generatePdf']);

//KEMBALI
Route::get('/export-kembali', [KembaliController::class, 'exportKembali'])->name('export-kembali');
Route::resource('/kembali', KembaliController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/kembali/{id}/edit', [KembaliController::class, 'edit'])->middleware('auth')->name('kembali.edit');
Route::put('/kembali/{id}', [KembaliController::class, 'update'])->middleware('auth')->name('kembali.update');
Route::delete('/kembali/{id}', [KembaliController::class, 'destroy'])->middleware('auth')->name('kembali.destroy');
Route::get('/kembali/{id}', [KembaliController::class, 'show'])->name('kembali.show');

//SERVICEDONE
Route::get('/servicedone/search', [ServiceDoneController::class, 'search'])->name('search.servicedone');
Route::resource('/servicedone', ServiceDoneController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/servicedone/{id}/edit', [ServiceDoneController::class, 'edit'])->middleware('auth')->name('servicedone.edit');
Route::put('/servicedone/{id}', [ServiceDoneController::class, 'update'])->middleware('auth')->name('servicedone.update');
Route::delete('/servicedone/{id}', [ServiceDoneController::class, 'destroy'])->middleware('auth')->name('servicedone.destroy');
Route::get('/export-servicedone', [ServiceDoneController::class, 'exportServiceDone'])->name('export-servicedone');
Route::get('/servicedone/{id}', [ServiceDoneController::class, 'show'])->name('servicedone.show');


//SERVICE PENDING
Route::get('/servicepending/search', [ServicePendingController::class, 'search'])->name('search.servicepending');
Route::resource('/servicepending', ServicePendingController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/servicepending/{id}/edit', [ServicePendingController::class, 'edit'])->middleware('auth')->name('servicepending.edit');
Route::put('/servicepending/{id}', [ServicePendingController::class, 'update'])->middleware('auth')->name('servicepending.update');
Route::delete('/servicepending/{id}', [ServicePendingController::class, 'destroy'])->middleware('auth')->name('servicepending.destroy');
Route::get('/export-servicepending', [ServicePendingController::class, 'exportServicePending'])->name('export-servicepending');
Route::get('/servicepending/{id}', [ServicePendingController::class, 'show'])->name('servicepending.show');
Route::get('/servicepending/finish/{id}', [ServicePendingController::class, 'finish'])->middleware('auth');


//KANIBAL
Route::get('/kanibal/search', [KanibalController::class, 'search'])->name('search.kanibal');
Route::resource('/kanibal', KanibalController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/kanibal/{id}/edit', [KanibalController::class, 'edit'])->middleware('auth')->name('kanibal.edit');
Route::put('/kanibal/{id}', [KanibalController::class, 'update'])->middleware('auth')->name('kanibal.update');
Route::delete('/kanibal/{id}', [KanibalController::class, 'destroy'])->middleware('auth')->name('kanibal.destroy');
Route::get('/export-kanibal', [KanibalController::class, 'exportKanibal'])->name('export-kanibal');
Route::get('/kanibal/{id}', [KanibalController::class, 'show'])->name('kanibal.show');
Route::get('/kanibal/finish/{id}', [KanibalController::class, 'finish'])->middleware('auth');

//SPAREPARTS
Route::resource('/spareparts', SparePartsController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/spareparts/{id}/edit', [SparePartsController::class, 'edit'])->middleware('auth')->name('spareparts.edit');
Route::put('/spareparts/{id}', [SparePartsController::class, 'update'])->middleware('auth')->name('spareparts.update');
Route::delete('/spareparts/{id}', [SparePartsController::class, 'destroy'])->middleware('auth')->name('spareparts.destroy');
Route::post('/import-spareparts', [SparePartsController::class, 'importSpareParts'])->middleware('auth')->name('import.spareparts');
Route::get('/export-spareparts', [SparePartsController::class, 'exportSpareParts'])->middleware('auth')->name('export.spareparts');
Route::get('/spareparts/{id}', [SparePartsController::class, 'show'])->name('spareparts.show');
Route::post('/spareparts/{id}', [SparePartsController::class, 'updateQuantity'])->middleware('auth')->name('update.quantity');
Route::get('download/{filename}', [SparePartsController::class, 'templateImport'])->name('download.template');

//History
Route::resource('/history', HistoryController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/export-sparepartsactivity', [HistoryController::class, 'SparePartsActivity'])->middleware('auth')->name('export.sparepartsactivity');

//Firmware
Route::prefix('firmware')->group(function () {
    Route::resource('/', FirmwareController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);

    Route::get('/table', [FirmwareController::class, 'table'])
        ->middleware('auth')
        ->name('firmware.table');

        Route::get('/{id}/edit', [FirmwareController::class, 'edit'])->middleware('auth')->name('firmware.edit');
        Route::put('/{id}', [FirmwareController::class, 'update'])->middleware('auth')->name('firmware.update');
        Route::delete('/{id}', [FirmwareController::class, 'destroy'])->middleware('auth')->name('firmware.destroy');
});
