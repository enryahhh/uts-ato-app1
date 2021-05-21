<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\AdminController;
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
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard-admin');
            // Route::view('/barang','admin.barang.index')->name('barang-admin');
            // Route::view('/barang/tambah','admin.barang.form')->name('addBarang-admin');
            Route::resource('jenis-barang', JenisBarangController::class);
            Route::resource('barang', BarangController::class);
        });
    });
    Route::middleware(['role:kasir'])->group(function () {
        Route::prefix('kasir')->group(function () {
            Route::view('/index','kasir.index')->name('kasir.index');
            Route::resource('barang', BarangController::class)->only(['show']);
        });
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
