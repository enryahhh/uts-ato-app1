<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisBarang;
class Barang extends Model
{
    use HasFactory;
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
}
