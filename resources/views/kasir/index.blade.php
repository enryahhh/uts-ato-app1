@extends('layouts.master-kasir')
@section('section-header','Tambah Transaksi')
@section('content-kasir')
<div class="card">
    <div class="card-header">
        <div class="h3">Daftar Transaksi</div>
    </div>
    <div class="card-body">
        <a href="{{route('kasir.add-transaksi')}}" class="btn btn-primary mb-4">Transaksi Baru</a>
        <table class="table table-striped dataTable no-footer" id="table-transaksi">
                        <thead>
                          <tr role="row">
                            <th>No</th>
                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                           </tr> 
                        </thead>
                        <tbody>
                            
                            @foreach($transaksi as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value->id_transaksi}}</td>
                                <td>{{$value->tgl_transaksi}}</td>
                                <td>Rp {{number_format($value->total_harga,0,'','.')}}/{{$value->satuan}}</td>
                                <td>{{$value->keterangan}}</td>
                                <td>
                                    <a href="" class="btn btn-info">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
    </div>
</div>
@push('script')
    <script>
        $(document).ready( function () {
            $('#table-transaksi').DataTable();
        } );
    </script>
@endpush

@endsection

