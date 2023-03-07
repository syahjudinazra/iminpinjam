<?php

use App\Http\Controllers\KembaliController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\ProductController;
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



Route::get('/export-users',[PinjamController::class,'exportUsers'])->name('export-users');
Route::get('/pinjam/search', [PinjamController::class, 'search'])->name('search.index');

Route::resource('/pinjam', PinjamController::class)->except([
    'show', 'edit', 'update', 'destroy',
]);

Route::get('/pinjam/{id}/edit', [PinjamController::class, 'edit'])->name('users.edit');
Route::put('/pinjam/{id}', [PinjamController::class, 'update'])->name('users.update');;
Route::get('/pinjam/{id}', [PinjamController::class, 'show'])->name('users.show');
Route::delete('/pinjam/{id}', [PinjamController::class, 'destroy'])->name('users.destroy');

Route::resource('/kembali', KembaliController::class);
