<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Barang;
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

    public function barang_r(){
        return belongsTo(Barang::class,'kode_barang');
    }

    public function getDetailTransaksiById($id){
        $data = DB::table('tb_detail_transaksi')
                ->join('tb_transaksi','tb_detail_transaksi.id_transaksi','=','tb_transaksi.id_transaksi')
                ->join('tb_barang','tb_detail_transaksi.kode_barang','=','tb_barang.kode_barang')
                ->select('tb_barang.nama_barang','tb_detail_transaksi.*')
                ->where('tb_detail_transaksi.id_transaksi','=',$id)->get();
                return $data;
    }

}
