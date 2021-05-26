<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
class AdminController extends Controller
{
    public function dashboard(){
        $barang = new Barang();
        $transaksi = new Transaksi();
        $pendapatan = $transaksi->getPendapatan();
        $jml = $barang->getJumlahAndStok();
        
        return view('admin.dashboard',["jumlah"=>$jml,"pendapatan"=>$pendapatan]);
    }
}
