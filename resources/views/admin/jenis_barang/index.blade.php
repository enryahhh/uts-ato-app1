@extends('layouts.master-admin')
@section('section-header','Data Jenis Barang')
@section('content-admin')

<div class="card">
    
    <div class="card-body">
    <div class="row align-items-end">
        <div class="col-md-7">
            <div class="form-group">
                <label for="">Jenis Barang</label>
                <input type="text" name="jenis" class="form-control" id="jenis">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button onclick="insertJenis()" id="btn_tambah" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
    <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Barang</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody id="body-table" data-id="{{count($jenis)}}">
            @foreach($jenis as $data)
            <tr id="row_{{$data['id_jenis']}}">
                <td data-iteration="{{$loop->iteration}}" class="no">{{$loop->iteration}}</td>
                <td>{{$data['nama_jenis']}}</td>
                <td>
                    <div id="aksi_{{$data['id_jenis']}}">
                        <a href="#" data-id="{{$data['id_jenis']}}" class="btn btn-info ubah">Ubah</a>
                        <button data-id="{{$data['id_jenis']}}" class="btn btn-danger hapus">Hapus</button>
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
    let cek = $("#body-table").data("id");
    let _token = $('meta[name="csrf-token"]').attr('content');
    const _header = {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": _token
            };

    function tes(){
        if(cek == 0){
            $("#body-table").html(` <tr id="cek">
                                <td colspan="3" class="text-center">Tidak Ada Data</td>
                            </tr>`);
        }else{

        }
    }

    tes();
    

    function insertJenis(){
        // cek+=1;
        let nama_jenis = $('#jenis').val();
        $.ajax({
            method:"POST",
            url:"{{route('jenis-barang.store')}}",
            data:{
                _token:_token,
                jenis:nama_jenis
            },
            dataType:"json",
            success:function(response){
                if(response.code == 200) {
                    $('#jenis').val('');
                    if($("#cek").length > 0){
                        $("#cek").remove();
                    }
                    let angka;
                    if($("table tbody tr").length == 0){
                        angka = 1;
                    }else{
                        let baris_iterasi = $("table tbody tr").last();
                        let kolom = baris_iterasi.find("td:first");
                            angka = kolom.data('iteration');
                            angka+=1;
                    }
                    $('table tbody').append('<tr id="row_'+response.data.id_jenis+'"><td data-iteration='+angka+'>'+angka+'</td><td>'+response.data.nama_jenis+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id_jenis+'" class="btn btn-info ubah">Ubah</a> <a href="javascript:void(0)" data-id="'+response.data.id_jenis+'" class="btn btn-danger" onclick="">Hapus</a></td></tr>');
              };
                },
            error:function(err){
                console.log(err);
            }
        })
    }
    $('.ubah').on('click',function(){
        $("#btn_tambah").attr("disabled",true);
        let id = $(this).data('id');
        let baris = $(this).closest("tr");
        let kolom = baris.find("td:nth-child(2)");
        let kolom_aksi = baris.find("td:nth-child(3)");
        let value = kolom.text();
        kolom.html(`<input type="text" focused name="jenis" id="inpt-${id}" value="${value}" class="form-control">`);
        kolom_aksi.find("#aksi_"+id).hide();
        kolom_aksi.append(`<div id="edit_${id}">
                      <button onclick="updateJenis(${id})" class="btn btn-success save">Simpan</button>       
                      <button onclick="kesemula(${id},'${value}')" class="btn btn-warning batal">Batal</button>
                    </div>`);

    })

    function kesemula(id,value){
        $("#row_"+id).find("td:nth-child(2)").html(value);
        $("#btn_tambah").attr("disabled",false);
        $("#edit_"+id).remove();
        $("#aksi_"+id).show();
    }

    function updateJenis(id){
        let newJenis = $("#inpt-"+id).val();
        let data = {
            nama_jenis:newJenis
        }
        console.log(id);
        fetch(`jenis-barang/${id}`,{
            method:'PUT',
            headers: _header,
            body: JSON.stringify(data)
        }).then((response)=>response.json())
        .then(result=>{
           if(result.code == 200){
               kesemula(result.data.id_jenis,result.data.nama_jenis);
           }
        })
        .catch((err)=>{
            console.log(err);
        })
    }

    $('.hapus').on('click',function(){
        let id = $(this).data('id');
     
        if(confirm('Apakah Anda Akan Menghapus Data ini?')){
                fetch(`jenis-barang/${id}`,{
                method:'DELETE',
                headers: _header,
            }).then((response)=>response.json())
            .then(result=>{
                if(result.code == 200){
                    $("table tbody").find("#row_"+id).remove();
                }
            })
            .catch((err)=>{
                console.log(err);
            })  
        }
            
    })
</script>
@endpush