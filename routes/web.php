<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FirmwareController;
use App\Http\Controllers\SparePartsController;
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
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetvalidasi'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password-reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetvalidasi'])->name('update.password');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

//PINJAM
Route::prefix('pinjam')->middleware('auth')->group(function () {
    Route::resource('/', PinjamController::class)->except([
    'show', 'edit', 'update', 'destroy']);
    Route::get('/export-pinjam', [PinjamController::class, 'exportPinjam'])->name('pinjam.export-pinjam');

    Route::get('/kembali', [PinjamController::class, 'kembaliPinjam'])->name('pinjam.kembali');
    Route::get('/Dipinjam', [PinjamController::class, 'index'])->name('pinjam.Dipinjam');

    Route::get('/dipinjam/{id}', [PinjamController::class, 'showDipinjam'])->name('pinjam.showDipinjam');
    Route::get('/dikembalikan/{id}', [PinjamController::class, 'showDikembalikan'])->name('pinjam.showDikembalikan');

    Route::get('/dipinjam/{id}/edit', [PinjamController::class, 'editDipinjam'])->name('pinjam.editDipinjam');
    Route::get('/dikembalikan/{id}/edit', [PinjamController::class, 'editDikembalikan'])->name('pinjam.editDikembalikan');
    Route::get('/dipinjam/{id}/move', [PinjamController::class, 'moveDipinjam'])->name('pinjam.moveDipinjam');

    Route::put('/dipinjam/{id}', [PinjamController::class, 'updateDipinjam'])->name('pinjam.updateDipinjam');
    Route::put('/dikembalikan/{id}', [PinjamController::class, 'updateDikembalikan'])->name('pinjam.updateDikembalikan');
    Route::delete('/{id}', [PinjamController::class, 'destroy'])->name('pinjam.destroy');
    Route::get('/generate-pdf/{id}', [PinjamController::class, 'generatePdf'])->name('pinjam.generate-pdf');
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
    ->name('firmware.table');

    Route::get('/{id}/edit', [FirmwareController::class, 'edit'])
    ->name('firmware.edit');

    Route::put('/{id}', [FirmwareController::class, 'update'])
    ->name('firmware.update');

    Route::delete('/{id}', [FirmwareController::class, 'destroy'])
    ->name('firmware.destroy');
});


//Stock
Route::prefix('stock')->middleware('auth')->group(function () {
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

        Route::get('/gudang/{id}', [StockController::class, 'showGudang'])->name('stock.showGudang');
        Route::get('/dipinjam/{id}', [StockController::class, 'showPinjam'])->name('stock.showPinjam');
        Route::get('/diservice/{id}', [StockController::class, 'showDiservice'])->name('stock.showDiservice');
        Route::get('/terjual/{id}', [StockController::class, 'showTerjual'])->name('stock.showTerjual');

        Route::get('/gudang/{id}/edit', [StockController::class, 'editGudang'])->name('stock.editGudang');
        Route::get('/dipinjam/{id}/edit', [StockController::class, 'editPinjam'])->name('stock.editPinjam');
        Route::get('/diservice/{id}/edit', [StockController::class, 'editDiservice'])->name('stock.editDiservice');
        Route::get('/terjual/{id}/edit', [StockController::class, 'editTerjual'])->name('stock.editTerjual');

        Route::put('/gudang/{id}', [StockController::class, 'updateGudang'])->name('stock.updateGudang');
        Route::put('/dipinjam/{id}', [StockController::class, 'updateDipinjam'])->name('stock.updateDipinjam');
        Route::put('/diservice/{id}', [StockController::class, 'updateDiservice'])->name('stock.updateDiservice');
        Route::put('/terjual/{id}', [StockController::class, 'updateTerjual'])->name('stock.updateTerjual');

        Route::delete('/{id}', [StockController::class, 'destroy'])->name('stock.destroy');
        Route::post('/import-stocks', [StockController::class, 'importStocks'])->name('import.stocks');
        Route::get('/export-stocks', [StockController::class, 'exportStocks'])->name('export.stocks');
        Route::get('download/{filename}', [StockController::class, 'templateImportStock'])->name('template.stocks');
        Route::post('/check-serial-numbers', [StockController::class, 'checkSerialNumbers'])->name('stock.checkSerialnumbers');
        Route::post('/update-data', [StockController::class, 'updateData'])->name('update.data');
});

//Service
Route::prefix('service')->middleware('auth')->group(function () {
    Route::resource('/', ServiceController::class)->except([
        'show', 'edit', 'update', 'destroy',
    ]);
    Route::get('/export-service', [ServiceController::class, 'exportService'])->name('export.service');
    Route::get('/export-all', [ServiceController::class, 'exportAll'])->name('export.allservice');

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

        Route::get('/antrian-pelanggan/{id}', [ServiceController::class, 'showAntrianPelanggan'])->name('service.showAntrianPelanggan');
        Route::get('/validasi-pelanggan/{id}', [ServiceController::class, 'showValidasiPelanggan'])->name('service.showValidasiPelanggan');
        Route::get('/selesai-pelanggan/{id}', [ServiceController::class, 'showSelesaiPelanggan'])->name('service.showSelesaiPelanggan');
        Route::get('/antrian-stock/{id}', [ServiceController::class, 'showAntrianStock'])->name('service.showAntrianStock');
        Route::get('/validasi-stock/{id}', [ServiceController::class, 'showValidasiStock'])->name('service.showValidasiStock');
        Route::get('/selesai-stock/{id}', [ServiceController::class, 'showSelesaiStock'])->name('service.showSelesaiStock');

        Route::get('/antrian-pelanggan/{id}/edit', [ServiceController::class, 'editAntrianPelanggan'])->name('service.editAntrianPelanggan');
        Route::get('/validasi-pelanggan/{id}/edit', [ServiceController::class, 'editValidasiPelanggan'])->name('service.editValidasiPelanggan');
        Route::get('/selesai-pelanggan/{id}/edit', [ServiceController::class, 'editSelesaiPelanggan'])->name('service.editSelesaiPelanggan');
        Route::get('/antrian-stock/{id}/edit', [ServiceController::class, 'editAntrianStock'])->name('service.editAntrianStock');
        Route::get('/validasi-stock/{id}/edit', [ServiceController::class, 'editValidasiStock'])->name('service.editValidasiStock');
        Route::get('/selesai-stock/{id}/edit', [ServiceController::class, 'editSelesaiStock'])->name('service.editSelesaiStock');

        Route::get('antrian-pelanggan/{id}/move', [ServiceController::class, 'moveAntrianPelanggan'])->name('service.moveAntrianPelanggan');
        Route::get('validasi-pelanggan/{id}/move', [ServiceController::class, 'moveValidasiPelanggan'])->name('service.moveValidasiPelanggan');
        Route::get('antrian-stock/{id}/move', [ServiceController::class, 'moveAntrianStock'])->name('service.moveAntrianStock');
        Route::get('validasi-stock/{id}/move', [ServiceController::class, 'moveValidasiStock'])->name('service.moveValidasiStock');

        Route::put('/antrian-pelanggan/{id}', [ServiceController::class, 'updateAntrianPelanggan'])->name('service.updateAntrianPelanggan');
        Route::put('/validasi-pelanggan/{id}', [ServiceController::class, 'updateValidasiPelanggan'])->name('service.updateValidasiPelanggan');
        Route::put('/selesai-pelanggan/{id}', [ServiceController::class, 'updateSelesaiPelanggan'])->name('service.updateSelesaiPelanggan');
        Route::put('/antrian-stock/{id}', [ServiceController::class, 'updateAntrianStock'])->name('service.updateAntrianStock');
        Route::put('/validasi-stock/{id}', [ServiceController::class, 'updateValidasiStock'])->name('service.updateValidasiStock');
        Route::put('/selesai-stock/{id}', [ServiceController::class, 'updateSelesaiStock'])->name('service.updateSelesaiStock');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
});
