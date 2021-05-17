<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_jenis';
    protected $table = 'tb_jenis_barang';
    protected $fillable = [
        "nama_jenis"
    ];
}
