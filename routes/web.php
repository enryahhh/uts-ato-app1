<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
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
Route::redirect('/', '/login')->middleware('guest');
Auth::routes([
    'register' => false
]);
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard-admin');
        Route::resource('barang', BarangController::class);
        Route::get('/transaksi',[TransaksiController::class,'index'])->name('admin.transaksi');
        Route::get('/transaksi/create',[TransaksiController::class,'addTransaksi'])->name('admin.add-transaksi');
        Route::post('/tambah-transaksi',[TransaksiController::class,'storeTransaksi'])->name('transaksi.store');
        Route::get('/detail-transaksi/{id_trans}',[TransaksiController::class,'detailTransaksi'])->name('transaksi.detail');
    });
    
});


