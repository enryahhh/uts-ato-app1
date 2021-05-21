<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_transaksi',
        'id_user',
        'tgl_transaksi',
        'total_harga',
        'total_bayar',
        'keterangan',
    ];

    public function barang(){
        
    }
}
