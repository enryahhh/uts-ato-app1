@extends('layouts.master-admin')
@section('section-header','Checkout')
@section('content-admin')

<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" name="penerima" class="form-control" id="penerima">
                    </div>

                    
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="provinsi" class="form-control" id="provinsi">
                            @foreach($provinsi as $item)
                            <option value="{{$item['province_id']}}">{{$item['province']}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Kota</label>
                        <select name="kota" class="form-control" id="kota">
                            <option value="">Pilih Kota</option>                        
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Kurir</label>
                        <select name="kurir" class="form-control" id="kurir">
                            <option value="">Pilih Kurir</option>
                            <option value="jne">Jne</option>
                            <option value="pos">Pos</option>
                            <option value="tiki">Tiki</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </div>
                </form>
               <div id="ongkir-list">

               </div>

            </div> <!-- end card-body -->

        </div>
    </div>

    <div class="col-lg">
        <div class="card">
            <div class="card-header">Belanjaan</div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-bordered" id="table-transaksi"  style="font-size:13px">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Kode Barang</td>
                                    <td>Qty</td>
                                    <td>Total Harga</td>
                                </tr>
                            </thead>

                            @if(session('cart'))
                            <tbody>
                                    @foreach(session('cart')['list_barang'] as $data)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}    
                                            </td>  
                                            <td>{{ $data['kode_barang'] }}</td>
                                            <td>{{ $data['qty'] }}</td>
                                            <td>{{ $data['harga']*$data['qty'] }}</td>
                                        </tr>
                                    @endforeach 
                                    <tr>
                                        <td colspan="3">Subtotal</td>
                                        <td id="subtotal">{{ session('cart')['total_bayar'] }}</td>
                                    </tr>
                                </tbody>
                                @endif
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col" id="ongkir-choosed">
                        
                    </div>
                </div>
                <button class="btn btn-primary" id="simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        let destination;
        let kurir;
        let _token = $('meta[name="csrf-token"]').attr('content');
        let dataTransaksi = {};
       $('#provinsi').change(function(){
           const province_id = $('option:selected').val();
           url = `/ongkir/${province_id}/city`;
           $.ajax({
               method:'GET',
               url:url,
               success:function(res){
                console.log(res.rajaongkir.results);
                let elm = '';
                const listKota = res.rajaongkir.results;
                for(kota of listKota){
                    elm += `<option value="${kota.city_id}">${kota.type} ${kota.city_name}</option>`;
                }
                    $("#kota").html(elm);
               }
           });
       });
       $('#kota').change(function(){
           destination = $('#kota option:selected').val(); 
       })

       $('#kurir').change(function(){
                url = '/ongkir/harga'
               kurir = $('#kurir option:selected').val()
            let data = {
                destination,
                kurir,
                _token
            }
            $.ajax({
                method:'POST',
                url:url,
                data:data,
                dataType:'json',
                success:function(res){
                    console.log(res.rajaongkir.results);
                    const costs = res.rajaongkir.results[0];
                    let services = '';
                    dataTransaksi.destination_detail = {
                        penerima: $("#penerima").val(),
                        destination: res.rajaongkir.destination_details,
                    };

                    for(const harga of costs.costs){
                        services += `
                            <tr>
                                <td> ${harga.service} </td>
                                <td> ${harga.description} </td>
                                <td> ${harga.cost[0].etd} </td>
                                <td> ${harga.cost[0].value} </td>
                                <td> <input type="radio" name="ongkir" class="harga-ongkir"> </td>
                            </tr>
                        `;
                    }
                    let table = `
                    <table class="table table-bordered" id="table-kurir"  style="font-size:13px">
                    <thead>
                        <tr>
                            <td>Layanan</td>
                            <td>Deskripsi</td>
                            <td>Etd</td>
                            <td>Harga</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>

                    <tbody>
                        ${services}
                    </tbody>
                </table>
                    `;
                    $("#ongkir-list").html(table);
                }
            });

            $("#ongkir-list").on('click','#table-kurir .harga-ongkir',function(){
                if($(this).is(':checked')){
                    let kolom = $(this).closest('tr').find('td:not(:last-child)');
                    let ongkir = $(kolom[3]).text();
                    let tipe = $(kolom[0]).text();
                    let subtotal = $("#subtotal").text();
                    dataTransaksi.ongkir = ongkir;
                    dataTransaksi.tipe = tipe;
                    dataTransaksi.total_harga = subtotal;
                    $("#ongkir-choosed").html(`
                        <p>Service : ${tipe}</p>
                        <p>Ongkir : ${ongkir}</p>
                        <p>Total Bayar : ${subtotal*1 + ongkir*1}</p>`);
                }
            });

            $("#simpan").click(function(){
                dataTransaksi.keterangan = $("#keterangan").val();
                dataTransaksi.kurir = kurir;
                dataTransaksi._token = _token;
                $.ajax({
                    url:"{{route('transaksi.store')}}",
                    method : "POST",
                    data : dataTransaksi,
                    dataType:"json",
                    success:function(res){
                        if(res.code == 200){
                            swal({
                                title: 'Pesan',
                                text: `${res.message}`,
                                icon: 'success',
                                closeOnClickOutside: false
                                }).then(()=>window.location.href = '/admin/transaksi');
                        }
                    },
                    error:function(err){
                        console.log(err);
                    }
                })
            })
       });


    </script>
@endpush