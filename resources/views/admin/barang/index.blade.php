@extends('layouts.master-admin')
@section('section-header','Data Barang')
@section('content-admin')

<div class="card">
    <div class="card-header">
        <div class="h3">Daftar Barang</div>
    </div>
    <div class="card-body">
        <a href="{{route('barang.create')}}" class="btn btn-primary float-right">Tambah Barang</a>
        <h2 class="text-center">
           
        </h2>
    </div>
</div>

@endsection