<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
class AdminController extends Controller
{
    public function dashboard(){
        $barang = new Barang();
        $jml = $barang->getJumlahAndStok();
        
        return view('admin.dashboard',["jumlah"=>$jml]);
    }
}
