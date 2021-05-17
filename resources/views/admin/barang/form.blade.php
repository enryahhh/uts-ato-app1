@extends('layouts.master-admin')
@section('section-header','Data Barang')
@section('content-admin')

<div class="card">
            <div class="card-body">
            @if (@session('pesan'))
            <div class="alert alert-success">
                <p>{{ session('pesan') }}</p>
            </div>
            @endif
                <!-- <h5 class="card-title">Special title treatment</h5> -->
                <div class="row">
                    <div class="col-md-12">
                    <form method="POST" action="{{route('barang.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" name="kode" readonly="" class="form-control" value="{{$kode}}" >
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama" class="form-control" id="formGroupExampleInput" >
                            @error('nama')
                                <h6 class="text-danger">{{ $message }}</h6>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control" id="inlineFormInputGroup">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-9">
                                <label>Harga</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" name="harga" class="form-control" id="inlineFormInputGroup">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">/ satuan</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">per</div>
                                    </div>
                                    <input type="text" disabled class="form-control" id="view-satuan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" id="inlineFormInputGroup" min="1">
                            <!-- <input type="number" class="form-control" id="formGroupExampleInput2" min="1"> -->
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control" id="inlineFormInputGroup" >
                            <!-- <input type="number" class="form-control" id="formGroupExampleInput2" min="1"> -->
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                    </div>
                </div>
            </div>
</div>

@endsection
@push('script')
<script>
    $("#satuan").keyup(function(event){
        $("#view-satuan").val($(this).val());
    })

</script>
@endpush