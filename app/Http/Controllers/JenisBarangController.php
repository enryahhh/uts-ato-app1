<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBarang;
use App\Models\Barang;
use App\Models\DetailTransaksi;
class JenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis_barang = JenisBarang::all();
        return view('admin.jenis_barang.index',['jenis'=>$jenis_barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $jenis = JenisBarang::create([
            'nama_jenis' => $request->jenis,
          ]);
    
    return response()->json(['code'=>200, 'message'=>'Data Berhasil Ditambahkan','data' => $jenis], 200);
        //
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
        $jenis = JenisBarang::find($id);
        $jenis->nama_jenis = $request->nama_jenis;
        $jenis->save();
        return response()->json(['code'=>200, 'message'=>'Data Berhasil diubah','data' => $jenis], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::where('id_jenis',$id)->get();
        if(count($barang) != 0){
            // dd($barang);
            foreach($barang as $item){
                $item->delete();
            }
        }
        $jenis = JenisBarang::find($id);
        $jenis->delete();
        return response()->json(['code'=>200, 'message'=>'Data Berhasil dihapus'], 200);
    }
}
