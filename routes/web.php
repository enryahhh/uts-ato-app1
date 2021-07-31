<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CekOngkirController;
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
Route::redirect('/', '/login')->middleware('guest');
Auth::routes([
    'register' => false
]);
Route::middleware(['auth'])->group(function () {
    Route::prefix('ongkir')->group(function () {
        Route::get('/province',[CekOngkirController::class,'index']);
        Route::get('/{provinceId}/city',[CekOngkirController::class,'getCity']);
        Route::post('/harga',[CekOngkirController::class,'cekOngkir']);
    });
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard-admin');
        Route::resource('barang', BarangController::class);
        Route::get('/transaksi',[TransaksiController::class,'index'])->name('admin.transaksi');
        Route::post('/checkout',[TransaksiController::class,'storeCart'])->name('admin.checkout');
        Route::get('/checkout-view',[TransaksiController::class,'checkoutView'])->name('admin.checkout-view');
        Route::get('/transaksi/create',[TransaksiController::class,'addTransaksi'])->name('admin.add-transaksi');
        Route::post('/tambah-transaksi',[TransaksiController::class,'storeTransaksi'])->name('transaksi.store');
        Route::get('/detail-transaksi/{id_trans}',[TransaksiController::class,'detailTransaksi'])->name('transaksi.detail');
    });
    
});


