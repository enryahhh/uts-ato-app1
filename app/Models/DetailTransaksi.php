<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'tb_detail_transaksi'; // tambahkan ini jika nama tabel tidak mengikuti bawaan laravel saat migration
    protected $primaryKey = 'id_detail_transaksi'; // tambahkan ini jika primary key tabel nya bukan 'id',lalu sesuaikan
    protected $fillabel = [
        'kode_barang',
        'id_transaksi',
        'harga',
        'qty',
    ];

}
