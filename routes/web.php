<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KembaliController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FirmwareController;
use App\Http\Controllers\SparePartsController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Route::get('/', function () {
//     // return view('auth.login');
//     return view('home');
// });

//User Settings
Route::prefix('user')->group(function () {
    Route::resource('/', UserSettingsController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);

});

//Maintenance
Route::get('/maintenance', function () {
    return view('maintenance');
});

//Dashboard
Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get('/home/total', [HomeController::class, 'total'])->middleware('auth');

//Lupa Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('forgot.password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->middleware('guest')->name('password-reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('update.password');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

//PINJAM
Route::middleware('auth')->group(function () {
    Route::get('/export-pinjam', [PinjamController::class, 'exportPinjam'])->name('export-pinjam');
    Route::resource('/pinjam', PinjamController::class)->except(['show', 'edit', 'update', 'destroy']);
    Route::get('pinjam/kembali', [PinjamController::class, 'kembaliPinjam'])->name('pinjam.kembali');
    Route::get('/pinjam/{id}/edit', [PinjamController::class, 'edit'])->name('users.edit');
    Route::put('/pinjam/{id}', [PinjamController::class, 'update'])->name('users.update');
    Route::delete('/pinjam/{id}', [PinjamController::class, 'destroy'])->name('users.destroy');
    Route::get('/pinjam/{id}', [PinjamController::class, 'show'])->name('users.show');
    Route::get('/generate-pdf/{id}', [PinjamController::class, 'generatePdf']);
});

//SPAREPARTS
Route::resource('/spareparts', SparePartsController::class)->middleware('auth')->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/spareparts/{id}/edit', [SparePartsController::class, 'edit'])->middleware('auth')->name('spareparts.edit');
Route::put('/spareparts/{id}', [SparePartsController::class, 'update'])->middleware('auth')->name('spareparts.update');
Route::delete('/spareparts/{id}', [SparePartsController::class, 'destroy'])->middleware('auth')->name('spareparts.destroy');
Route::post('/import-spareparts', [SparePartsController::class, 'importSpareParts'])->middleware('auth')->name('import.spareparts');
Route::get('/export-spareparts', [SparePartsController::class, 'exportSpareParts'])->middleware('auth')->name('export.spareparts');
Route::get('/spareparts/{id}', [SparePartsController::class, 'show'])->middleware('auth')->name('spareparts.show');
Route::post('/spareparts/{id}', [SparePartsController::class, 'updateQuantity'])->middleware('auth')->name('update.quantity');
Route::get('download/{filename}', [SparePartsController::class, 'templateImport'])->middleware('auth')->name('download.template');

//History
Route::resource('/history', HistoryController::class)->middleware('auth')->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/export-sparepartsactivity', [HistoryController::class, 'SparePartsActivity'])->middleware('auth')->name('export.sparepartsactivity');

//Firmware
Route::prefix('firmware')->middleware('auth')->group(function () {
    Route::resource('/', FirmwareController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);

    Route::get('/table', [FirmwareController::class, 'table'])
    ->middleware('auth')
        ->name('firmware.table');

    Route::get('/{id}/edit', [FirmwareController::class, 'edit'])
    ->middleware('auth')
        ->name('firmware.edit');

    Route::put('/{id}', [FirmwareController::class, 'update'])
    ->middleware('auth')
        ->name('firmware.update');

    Route::delete('/{id}', [FirmwareController::class, 'destroy'])
    ->middleware('auth')
        ->name('firmware.destroy');
});


//Stock
Route::prefix('stock')->middleware('auth')->group(function () {
    Route::resource('/', StockController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);

    Route::get('/gudang', [StockController::class, 'gudang'])->middleware('auth')
        ->name('stock.gudang');
    Route::get('/service', [StockController::class, 'service'])->middleware('auth')
        ->name('stock.service');
    Route::get('/dipinjam', [StockController::class, 'dipinjam'])->middleware('auth')
        ->name('stock.dipinjam');
    Route::get('/terjual', [StockController::class, 'terjual'])->middleware('auth')
        ->name('stock.terjual');

        Route::get('/{id}/edit', [StockController::class, 'edit'])->middleware('auth')->name('stock.edit');
        Route::put('/{id}', [StockController::class, 'update'])->middleware('auth')->name('stock.update');
        Route::delete('/{id}', [StockController::class, 'destroy'])->middleware('auth')->name('stock.destroy');
        Route::post('/import-stocks', [StockController::class, 'importStocks'])->middleware('auth')->name('import.stocks');
        Route::get('/export-stocks', [StockController::class, 'exportStocks'])->middleware('auth')->name('export.stocks');
        Route::get('download/{filename}', [StockController::class, 'templateImportStock'])->middleware('auth')->name('template.stocks');
        Route::post('/check-serial-numbers', [StockController::class, 'checkSerialNumbers'])->middleware('auth')->name('stock.checkSerialnumbers');
        Route::post('/update-data', [StockController::class, 'updateData'])->middleware('auth')->name('update.data');


});

//Service
Route::prefix('service')->middleware('auth')->group(function () {
    Route::resource('/', ServiceController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);

    Route::get('/antrianPelanggan', [ServiceController::class, 'antrianPelanggan'])
        ->middleware('auth')
        ->name('service.antrianPelanggan');
    Route::get('/validasiPelanggan', [ServiceController::class, 'validasiPelanggan'])
        ->middleware('auth')
        ->name('service.validasiPelanggan');
    Route::get('/selesaiPelanggan', [ServiceController::class, 'selesaiPelanggan'])
        ->middleware('auth')
        ->name('service.selesaiPelanggan');

    Route::get('/antrianStock', [ServiceController::class, 'antrianStock'])
        ->middleware('auth')
        ->name('service.antrianStock');
    Route::get('/validasiStock', [ServiceController::class, 'validasiStock'])
        ->middleware('auth')
        ->name('service.validasiStock');
    Route::get('/selesaiStock', [ServiceController::class, 'selesaiStock'])
        ->middleware('auth')
        ->name('service.selesaiStock');

        Route::get('/{id}', [ServiceController::class, 'show'])->middleware('auth')->name('service.show');
        Route::get('/{id}/edit', [ServiceController::class, 'edit'])->middleware('auth')->name('service.edit');
        Route::put('/{id}', [ServiceController::class, 'update'])->middleware('auth')->name('service.update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->middleware('auth')->name('service.destroy');
        Route::get('/export-service', [ServiceController::class, 'exportService'])->middleware('auth')->name('export.service');
        Route::get('/export-all', [ServiceController::class, 'exportAll'])->middleware('auth')->name('export.allservice');
});


