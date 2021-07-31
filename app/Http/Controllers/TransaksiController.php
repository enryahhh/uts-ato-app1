<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Carbon\Carbon;
use App\Http\Controllers\CekOngkirController;
class TransaksiController extends Controller
{
    public function index(){
                $transaksi = Transaksi::all();
                
                return view('admin.transaksi.index',['transaksi'=>$transaksi]);
    }

    public function addTransaksi(){
        $barang = Barang::all();
        
        return view('admin.transaksi.form-transaksi',['barang'=>$barang]);
    }
    
    public function checkoutView(){
        $provinsi = new CekOngkirController();
        return view('admin.transaksi.checkout',['provinsi'=>$provinsi->index()]);
    }

    public function storeCart(Request $request){
        session()->put('cart',$request->cart);
        return response()->json(['code'=>200], 200);
    }

    public function storeTransaksi(Request $request){
        DB::transaction(function () use($request){
            $id_trans = Transaksi::pluck('id_transaksi')->last();
            $day = Carbon::now()->format('d');
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $format_id = $day.$month.substr($year,-2);
            $detail;
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
            $kurir = isset($request->kurir) ? $request->kurir."-".$request->tipe : NULL;
            $ongkir = isset($request->ongkir) ? $request->ongkir : NULL;
            $destination_detail = isset($request->destination_detail) ? json_encode($request->destination_detail) : NULL;
            // dd($destination_detail);
            // dd($request->all());
            if(isset($request->barang)){
                $detail = $request->barang;
            }else{
                $detail = session()->get('cart')['list_barang'];
            }
            $transaksi = Transaksi::create([
                "id_transaksi"=>$new_kode,
                "id_user"=>\Auth::user()->id,
                "tgl_transaksi"=>Carbon::now()->format('Y-m-d'),
                "kurir" =>$kurir,
                "ongkir" =>$ongkir,
                "total_harga"=>$request->total_harga,
                "keterangan"=>$request->keterangan,
                "destination_detail" => $destination_detail
            ]);
            
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
            for($j=0;$j<count($detail);$j++){
                $barang = new Barang;
                $barang->kurangiStok($detail[$j]["kode_barang"],$detail[$j]["qty"]);
            }
            session()->forget('cart');
        });
        return response()->json(['code'=>200, 'message'=>'Transaksi Berhasil'], 200);
    }

    public function detailTransaksi($id){
        $detail = new DetailTransaksi;
        $data = $detail->getDetailTransaksiById($id);
        $total = 0;
        foreach($data as $value){
            $total += $value->harga * $value->qty;
        }
        return response()->json(['code'=>200, 'data'=>$data,'total'=>$total], 200);
    }
}
