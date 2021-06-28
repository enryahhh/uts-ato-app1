<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        return view('admin.barang.index',['barang'=>$barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode_barang = Barang::withTrashed()->pluck('kode_barang')->last();
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

    public function uploadImage($filenya){
        $file = $filenya;
        $nama_file = time()."_".$file->getClientOriginalName();
      
		$file->move("img",$nama_file);
        return $nama_file;
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
            "foto"=>$nama_file,
            "stok"=>$request->stok,
            "id_jenis"=>$request->id_jenis
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
        $barang = Barang::find($id);
        if($barang != null){
            return response()->json(['code'=>200,'barang'=>$barang]);
        }else{
            return response()->json(['code'=>200,'pesan'=>"Kode Barang Tidak Valid"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = Barang::find($id);
        return view('admin.barang.update',['data'=>$barang]);
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
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'foto' => 'file|image|mimes:jpeg,png,jpg|max:1024',
        ]);
        $barang = Barang::find($id);
        $nama_file =$barang->foto;
        if($request->file('foto') != null){
            $nama_file = $this->uploadImage($request->file('foto'));
        }
        $barang->kode_barang = $request->kode;
        $barang->nama_barang = $request->nama;
        $barang->harga =  $request->harga;
        $barang->satuan = $request->satuan;
        $barang->foto = $nama_file;
        $barang->stok=$request->stok;
        $barang->save();
        return redirect()->route('barang.index')->with('pesan','Berhasil Mengubah Data Barang');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::where('kode_barang',$id)->delete();
  
        return redirect()->route('barang.index')
                        ->with('pesan','Data Berhasil Di Hapus');
    }
}
