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
Route::get('/', [HomeController::class, 'index']);
Route::get('/home/total', [HomeController::class, 'total']);

//Lupa Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('forgot.password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->middleware('guest')->name('password-reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetvalidasi'])->middleware('guest')->name('update.password');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

//Stock
Route::prefix('stock')->group(function () {
    Route::resource('/', StockController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);

    Route::get('/gudang', [StockController::class, 'gudang'])
        ->name('stock.gudang');
    Route::get('/service', [StockController::class, 'service'])
        ->name('stock.service');
    Route::get('/dipinjam', [StockController::class, 'dipinjam'])
        ->name('stock.dipinjam');
    Route::get('/terjual', [StockController::class, 'terjual'])
        ->name('stock.terjual');

        Route::get('/{id}/edit', [StockController::class, 'edit'])->middleware('auth')->name('stock.edit');
        Route::put('/{id}', [StockController::class, 'update'])->middleware('auth')->name('stock.update');
        Route::delete('/{id}', [StockController::class, 'destroy'])->middleware('auth')->name('stock.destroy');
        Route::post('/import-stocks', [StockController::class, 'importStocks'])->middleware('auth')->name('import.stocks');
        Route::get('/export-stocks', [StockController::class, 'exportStocks'])->middleware('auth')->name('export.stocks');
        Route::get('download/{filename}', [StockController::class, 'templateImportStock'])->name('template.stocks');
        Route::post('/check-serial-numbers', [StockController::class, 'checkSerialNumbers'])->name('stock.checkSerialnumbers');
        Route::post('/update-data', [StockController::class, 'updateData'])->name('update.data');


});

//Service
Route::prefix('service')->group(function () {
    Route::resource('/', ServiceController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);

    Route::get('/antrianPelanggan', [ServiceController::class, 'antrianPelanggan'])
        ->name('service.antrianPelanggan');
    Route::get('/validasiPelanggan', [ServiceController::class, 'validasiPelanggan'])
        ->name('service.validasiPelanggan');
    Route::get('/selesaiPelanggan', [ServiceController::class, 'selesaiPelanggan'])
        ->name('service.selesaiPelanggan');

    Route::get('/antrianStock', [ServiceController::class, 'antrianStock'])
        ->name('service.antrianStock');
    Route::get('/validasiStock', [ServiceController::class, 'validasiStock'])
        ->name('service.validasiStock');
    Route::get('/selesaiStock', [ServiceController::class, 'selesaiStock'])
        ->name('service.selesaiStock');

        Route::get('/{id}', [ServiceController::class, 'show'])->middleware('auth')->name('service.show');
        Route::get('/{id}/edit', [ServiceController::class, 'edit'])->middleware('auth')->name('service.edit');
        Route::put('/{id}', [ServiceController::class, 'update'])->middleware('auth')->name('service.update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->middleware('auth')->name('service.destroy');
    //     Route::post('/import-stocks', [ServiceController::class, 'importStocks'])->middleware('auth')->name('import.stocks');
        Route::get('/export-service', [ServiceController::class, 'exportService'])->middleware('auth')->name('export.service');
    //     Route::get('download/{filename}', [ServiceController::class, 'templateImportStock'])->name('template.stocks');
});


