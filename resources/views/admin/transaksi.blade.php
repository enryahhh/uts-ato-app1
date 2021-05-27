@extends('layouts.master-admin')
@section('section-header','Dashboard')
@section('content-admin')


<div class="card">
    <div class="card-header">
        <div class="h3">Daftar Transaksi</div>
    </div>
    <div class="card-body">
        <table class="table table-striped dataTable no-footer" id="table-transaksi" style="font-size: 13px;">
                        <thead>
                          <tr role="row">
                            <th>No</th>
                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Keterangan</th>
                            <th>Kasir</th>
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
                                <td>{{$value->user_r->nama}}</td>
                                <td>
                                    <button onclick="detailModal('{{$value->id_transaksi}}')" class="btn btn-info">Detail</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
    </div>
</div>

@endsection
@include('utilities.modal-detail')