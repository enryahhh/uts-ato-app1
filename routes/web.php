<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransaksiController;
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
Auth::routes([
    'register' => false
]);
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard-admin');
            // Route::view('/barang','admin.barang.index')->name('barang-admin');
            // Route::view('/barang/tambah','admin.barang.form')->name('addBarang-admin');
            Route::get('/transaksi',[TransaksiController::class,'index'])->name('admin.transaksi');
            Route::resource('jenis-barang', JenisBarangController::class);
            Route::resource('barang', BarangController::class);
        });
    });
    Route::middleware(['role:kasir'])->group(function () {
        Route::prefix('kasir')->group(function () {
            Route::get('/index',[TransaksiController::class,'index'])->name('kasir.index');
            Route::get('/transaksi',[TransaksiController::class,'addTransaksi'])->name('kasir.add-transaksi');
            Route::resource('barang', BarangController::class)->only(['show']);
        });
    });
    Route::get('/detail-transaksi/{id_trans}',[TransaksiController::class,'detailTransaksi'])->name('transaksi.detail');
    Route::post('/tambah-transaksi',[TransaksiController::class,'storeTransaksi'])->name('transaksi.store');
});


// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
