@extends('layouts.master-kasir')
@section('section-header','Tambah Transaksi')
@section('content-kasir')

<h2 class="section-title">Transaksi</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card">
              <div class="card-header">
                <h4>Cari Barang</h4>
              </div>
              <!-- card body -->
                <div class="card-body">
                    <!-- input cari barang -->
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="kd_brg" id="kd_brg" placeholder="kode barang" aria-label="">
                            <div class="input-group-append">
                            <button class="btn btn-primary" id="btn-cari" type="button">Cari</button>
                            </div>
                        </div>
                    </div>
                   <!-- end input cari barang -->

                   <!-- tampil barang -->
                   <div class="tampil-barang">
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" name="nama_brg" readonly class="form-control" id="nama-brg">
                        </div>

                        <div class="form-group">
                            <label>Harga</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="number" value="" readonly name="harga" id="harga-brg" class="form-control" id="inlineFormInputGroup">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="jumlah" readonly placeholder="" id="jml-beli">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">per-<span id="satuan"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Total</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="number" value="0" readonly name="total" id="total-harga" class="form-control" id="inlineFormInputGroup">
                            </div>
                        </div>

                        <button class="btn btn-success" id="btn-beli" disabled>Beli</button>
                   </div>
                   <!-- end tampil barang -->
                </div>
                <!-- end card body -->
        </div>
    </div>

    <div class="col">
        <div class="card">
              <div class="card-header">
                <h4>Transaksi</h4>
              </div>
              <!-- card body -->
              <div class="card-body">
                  <!-- tabel transaksi -->
                    <table class="table table-bordered" id="table-transaksi"  style="font-size:13px">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th>Nama Barang</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Total</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr id="total-bayar">
                            <td colspan="4" class="text-right">Total Bayar</td>
                            <td colspan="2" class="text-left"></td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- end tabel transaksi -->
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary pembayaran" data-toggle="modal" data-target="#exampleModal">Pembayaran</button>
                    </div>

                    
              </div>
              <!-- end card body -->
              
            </div>
    </div>

</div>

@endsection
<div class="modal fade" id="exampleModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <!-- row -->
            <div class="row form-bayar">
                <div class="col">
                    <div class="form-group">
                        <label for="">Total Harga</label>
                        <input type="number" class="form-control" name="" id="bayar-total-hrg">
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah Uang</label>
                        <input type="number" class="form-control" name="" id="uang">
                    </div>

                    <div class="form-group">
                        <label for="">Kembalian</label>
                        <input type="number" class="form-control" readonly name="" id="kembalian">
                    </div>
                </div>
            </div>
            <!-- end row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary bayar-transaksi">Bayar</button>
      </div>
    </div>
  </div>
</div>
@push('script')
    <script>
        let _token = $('meta[name="csrf-token"]').attr('content');
        let data = Object.create({});
       $(document).ready(function(){
             // $('.tampil-barang').hide();
        //  Fungsi Cari Barang
        $("#btn-cari").on('click',function(){
            // $('.tampil-barang').show();
            let kode = $("#kd_brg").val();
            $.ajax({
                method:'GET',
                url:`barang/${kode}`,
                success:function(res){
                    if(res.barang != null){
                        const brg = res.barang;
                        $("#nama-brg").val(brg.nama_barang);
                        $("#harga-brg").val(brg.harga);
                        $("#jml-beli").removeAttr("readonly");
                        $("#satuan").html(brg.satuan);
                        $("#btn-beli").removeAttr("disabled");
                    }
                }
            })
        });

        // Fungsi hitung total harga
        $("#jml-beli").on('keyup',function(){
           let harga = $("#harga-brg").val();
           let total = harga * $(this).val();
            $("#total-harga").val(total);
        });

        let no = 0;
        let total_bayar = 0;
        let list_barang = [];
        let uang = 0;
        $("#total-bayar").hide();
        // Fungsi Menambah data ke tabel
        $("#btn-beli").on('click',function(){
            let cek = $("#table-transaksi").find(`.kd-${kd_brg.value}`);
            $("#total-bayar").show();
            if(cek.length < 1){
                no+=1;
                // const nama_brg = $("#nama-brg").val();
                // const harga = $("#harga-brg").val();
                const val_inp = $(":input").serializeArray();
                const [,kd_brg,nama_brg,harga,jumlah,total] = val_inp;
                $("table tbody").prepend(`
                    <tr class="kd-${kd_brg.value}">
                        <td>${no}</td>
                        <td>${nama_brg.value}</td>
                        <td>${harga.value}</td>
                        <td>${jumlah.value}</td>
                        <td>${total.value}</td>
                        <td>
                                <a class="btn btn-info btn-icon btn-qty"  data-id="${kd_brg.value}"><i class="fas fa-pencil-alt"></i></a>      
                                <button class="btn btn-danger btn-icon hapus-pembelian" data-id="${kd_brg.value}"><i class="fas fa-trash"></i></button>
                          </td>
                    </tr>
                `);
                total_bayar += total.value*1;
                $(":input").val("");
                list_barang.push({
                        kode_barang:kd_brg.value,
                        harga:harga.value,
                        qty:jumlah.value,
                    });
                
                console.log(total_bayar);
            }else{
                console.log('Data sudah ada');
            }
            $("#total-bayar td:nth-child(2)").text(total_bayar);
            // $("#total-hrg").val(total_bayar);
            // $("table tbody").last().before("<tr><td>"+no+"</td></tr>");
            

        });

        // $(document).on('click',function(e){
        //     let className = e.target.classList;
        //     let kd = '';
        //     if(className.contains('btn-qty')){
        //         kd = e.target.dataset.id;
        //     }else if(className.contains('hapus-pembelian')){
        //         kd = e.target.dataset.id;
        //         hapusPembelian(kd);
        //     }
        //     console.log(kd);
        // });

        // Fungsi menampilkan modal dan pembayaran
        $('.pembayaran').on('click',function(){
            let total =$("#total-bayar td:nth-child(2)").text();
            $("#bayar-total-hrg").val(total);
        });

        $('#uang').on("keyup",function(){
            uang = $(this).val();
            let kembalian;
            let total_hrg = $("#bayar-total-hrg").val();
            if(uang*1 < total_hrg){
                kembalian = 0;
            }else{
                kembalian = uang - total_hrg;
            }
            $("#kembalian").val(kembalian);
            console.log(uang);
        });

        $('#exampleModal').on('hidden.bs.modal', function (event) {
            $('.form-bayar').find(":input").val("");
        });

        $(".bayar-transaksi").on("click",function(){
            data._token = _token;
            data.barang = list_barang;
            data.total_harga = total_bayar;
            data.total_bayar =  uang;
            data.keterangan = "ini keterangan";
            console.log(data);
            $.ajax({
                url:"{{route('transaksi.store')}}",
                method : "POST",
                data : data,
                dataType:"json",
                success:function(res){
                    console.log(res);
                }
            })
        });

        $(".hapus-pembelian").on('click',function(){
            let id = $(this).data('id');
            console.log(id+"asd");
        });

    //     function hapusPembelian(kode){
    //         console.log(kode+"asd");
    //         $("table tbody").find(".kd-"+kode).remove();
    //     }
       });
    </script>
@endpush
