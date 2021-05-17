<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode_barang = Barang::pluck('kode_barang')->last();
        if($kode_barang == null){
            $new_kode = "BRG-001";
        }else{
            $new_kode = explode("-",$kode_barang)[1];
            $new_kode += 1;
            if($new_kode <=100){
                $new_kode = sprintf("BRG-%03d", $new_kode);
            }else{
                $new_kode="BRG-".$new_kode;
            }
        }

        return view('admin.barang.form',['kode'=>$new_kode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ' :attribute barang tidak boleh kosong.',
        ];
        
        // $validator = Validator::make($input, $rules, $messages);
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'foto' => 'required|file|image|mimes:jpeg,png,jpg|max:1024',
        ],$messages);
       
        // dd($request->all());
        $nama_file = $this->uploadImage($request->file('foto'));
        $barang = Barang::create([
            "kode_barang" => $request->kode,
            "nama_barang" => $request->nama,
            "harga" =>  $request->harga,
            "satuan"=> $request->satuan,
            "stok"=>$request->stok,
            "foto"=>$nama_file
        ]);

        return redirect()->route("barang.create")->with('pesan','Berhasil Menambahkan Data Barang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
