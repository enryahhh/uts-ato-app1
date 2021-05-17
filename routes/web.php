<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JenisBarangController;
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

Route::prefix('admin')->group(function () {
    Route::view('/dashboard','admin.dashboard')->name('dashboard-admin');
    // Route::view('/barang','admin.barang.index')->name('barang-admin');
    // Route::view('/barang/tambah','admin.barang.form')->name('addBarang-admin');
    Route::resource('barang', BarangController::class);
    Route::resource('jenis-barang', JenisBarangController::class);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
