<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisBarang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class Barang extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'kode_barang';
    protected $table = 'tb_barang';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'foto',
        'harga',
        'stok',
        'id_jenis'
    ];
    public $incrementing = false;

    public function jenis_barang(){
        return $this->belongsTo(JenisBarang::class,'id_jenis','id_jenis');
    }


    public function getJumlahAndStok(){
        $jml_barang = DB::table('tb_barang')->count();
        $jml_stok = DB::table('tb_barang')->sum('stok');
        return ['jml_barang'=>$jml_barang,'jml_stok'=>$jml_stok];
    }

    public function kurangiStok($kode,$jumlah){
        $stok = DB::table('tb_barang')->where('kode_barang',$kode)->decrement('stok',$jumlah);
    }
}
