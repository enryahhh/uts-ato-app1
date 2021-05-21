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
                    <table class="table table-bordered" id="table-transaksi">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Barang</th>
                          <th scope="col">Harga</th>
                          <th scope="col">Jumlah</th>
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
              </div>
              <!-- end card body -->
              <div class="card-footer bg-whitesmoke">
                This is card footer
              </div>
            </div>
    </div>

</div>

@endsection
@push('script')
    <script>
       $(document).ready(function(){
             // $('.tampil-barang').hide();
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

        $("#jml-beli").on('keyup',function(){
           let harga = $("#harga-brg").val();
           let total = harga * $(this).val();
            $("#total-harga").val(total);
        });

        let no = 0;
        let total_bayar = 0;
        $("#total-bayar").hide();
        $("#btn-beli").on('click',function(){
            let cek = $("#table-transaksi").find(`#kd-${kd_brg.value}`);
            $("#total-bayar").show();
            if(cek.length < 1){
                no+=1;
                // const nama_brg = $("#nama-brg").val();
                // const harga = $("#harga-brg").val();
                const val_inp = $(":input").serializeArray();
                const [,kd_brg,nama_brg,harga,jumlah,total] = val_inp;
                $("table tbody").last().before(`
                    <tr id="kd-${kd_brg.value}">
                        <td>${no}</td>
                        <td>${nama_brg.value}</td>
                        <td>${harga.value}</td>
                        <td>${jumlah.value}</td>
                        <td>${total.value}</td>
                        <td>
                                <a class="btn btn-info btn-icon btn-qty"  data-id="${kd_brg.value}"><i class="fas fa-pencil-alt"></i></a>      
                                <button class="btn btn-danger btn-icon"><i class="fas fa-trash"></i></button>
                          </td>
                    </tr>
                `);
                total_bayar += total.value*1;
                console.log(total_bayar);
            }else{
                console.log('Data sudah ada');
            }
            $("#total-bayar td:nth-child(2)").text(total_bayar);
            // $("table tbody").last().before("<tr><td>"+no+"</td></tr>");
            

        });

        $(document).on('click',function(e){
            if(e.target.classList.contains('btn-qty')){
                const kd = e.target.dataset.id;
            }
        });

       });
    </script>
@endpush