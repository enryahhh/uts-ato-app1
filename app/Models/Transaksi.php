<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_transaksi',
        'id_user',
        'tgl_transaksi',
        'kurir',
        'ongkir',
        'total_harga',
        'keterangan',
        'destination_detail'
    ];
    public $incrementing = false;

    public function getPendapatan(){
        $pendapatan = DB::table('tb_transaksi')->sum('total_harga');
        $jml_trs = DB::table('tb_transaksi')->count();
        return ['pendapatan'=>$pendapatan,'jml_trs'=>$jml_trs];
    }

    public function user_r(){
        return $this->belongsTo(User::class,'id_user');
    }
}
