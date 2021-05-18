@extends('layouts.master-admin')
@section('section-header','Data Barang')
@section('content-admin')

<div class="card">
    <div class="card-header">
        <div class="h3">Daftar Barang</div>
    </div>
    <div class="card-body">
    @if (@session('pesan'))
            <div class="alert alert-success pesan">
                <p>{{ session('pesan') }}</p>
            </div>
            @endif
        <a href="{{route('barang.create')}}" class="btn btn-primary float-right">Tambah Barang</a>
        <table class="table table-striped dataTable no-footer" id="table-1">
                        <thead>
                          <tr role="row">
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Tambah Stok</th>
                            <th>Aksi</th>
                           </tr> 
                        </thead>
                        <tbody>
                            @foreach($barang as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value->nama_barang}}</td>
                                <td>{{$value->jenis_barang->nama_jenis}}</td>
                                <td>Rp {{number_format($value->harga,0,'','.')}}/{{$value->satuan}}</td>
                                <td>{{$value->stok}}</td>
                                <td>
                                    <img width="200px" src="{{asset('storage/img/'.$value->foto)}}" alt="tes">
                                </td>
                                <td class="text-center">
                                    <a href="" class="btn btn-icon btn-dark"><i class="far fa-plus-square"></i></a>
                                </td>
                                <td>
                                    <div class="row">
                                    <a href="{{route('barang.edit',$value->kode_barang)}}" class="btn btn-info btn-icon mr-1"><i class="far fa-edit"></i></a> 
                                    <form action="{{route('barang.destroy',$value->kode_barang)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  onClick="return confirm('Anda Yakin Ingin Menghapus Data Ini?')" class="delete btn btn-danger btn-icon">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
    </div>
</div>

@endsection
@push('script')
    <script>
        // $("#table-1").dataTable({
        //     "columnDefs": [
        //         { "sortable": false, "targets": [2,3] }
        //     ]
        // });
        $(document).ready( function () {
            $('#table-1').DataTable();
        } );
    </script>
@endpush