<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
class TransaksiController extends Controller
{
    public function index(){
            $transaksi = Transaksi::all();
            if(\Auth::user()->role == 'kasir'){
                return view('kasir.index',['transaksi'=>$transaksi]);
            }else{
                return view('admin.transaksi',['transaksi'=>$transaksi]);
            }
    }

    public function storeTransaksi(Request $request){
        $id_trans = Transaksi::pluck('id_transaksi')->last();
        $day = Carbon::now()->format('d');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $format_id = $day.$month.substr($year,-2);
        if($id_trans == null){
            $new_kode = "TRS001".$format_id;
        }else{
            $new_kode = substr($id_trans,3,-6);
            $new_kode += 1;
            if($new_kode <=100){
                $new_kode = sprintf("TRS%'.03d", $new_kode);
                $new_kode = $new_kode.$format_id;
            }else{
                $new_kode="TRS".$new_kode.$format_id;
            }
        }
        // dd($request->barang);
        $transaksi = Transaksi::create([
            "id_transaksi"=>$new_kode,
            "id_user"=>\Auth::user()->id,
            "tgl_transaksi"=>Carbon::now()->format('Y-m-d'),
            "total_harga"=>$request->total_harga,
            "total_bayar"=>$request->total_bayar,
            "keterangan"=>$request->keterangan
        ]);
        $detail = $request->barang;
        for($i=0;$i < count($detail);$i++){
            $detail[$i]["id_transaksi"] = $new_kode;
        }
        // dd($detail);
        DetailTransaksi::upsert($detail,[
            'kode_barang',
            'id_transaksi',
            'harga',
            'qty',
        ]);
        return response()->json(['code'=>200, 'message'=>'Transaksi Berhasil'], 200);
    }

    public function detailTransaksi(){

    }
}
