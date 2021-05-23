<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'total_harga',
        'total_bayar',
        'keterangan',
    ];
    public $incrementing = false;

    public function user_r(){
        return $this->belongsTo(User::class,'id_user');
    }
}
