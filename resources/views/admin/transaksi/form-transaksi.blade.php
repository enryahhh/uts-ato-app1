@extends('layouts.master-admin')
@section('section-header','Tambah Transaksi')
@section('content-admin')

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
                            <select class="cari-barang">
                            <option></option>
                                @foreach($barang as $item)
                                    <option value="{{$item->kode_barang}}">{{$item->nama_barang}}</option>
                                @endforeach
                            </select>
                            <!-- </div> -->
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
                        <button class="btn btn-primary pembayaran" data-toggle="modal" disabled="" data-target="#exampleModal">Pembayaran</button>
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

                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control"></textarea>
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
        let no = 0;
        let total_bayar = 0;
        function coba(){
            if($("table tr").length > 2){
               $("#total-bayar").show();
               $(".pembayaran").removeAttr('disabled');
           }else{
               no = 0;
               $("#total-bayar").hide();
               $(".pembayaran").attr('disabled','');
               $("#total-bayar td:nth-child(2)").text("0");
           }
        }
       $(document).ready(function(){
       
        let list_barang = [];
        let uang = 0;
            coba();
             $('.cari-barang').select2({
                placeholder: 'Cari Barang'
            
            })

            // Fungsi Cari Barang 
            $('.cari-barang').change(function(){
                let kode = $(this).val();
                console.log(kode);
                if(kode != ''){
                        $.ajax({
                        method:'GET',
                        url:`/admin/barang/${kode}`,
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
                }
            })

        // Fungsi hitung total harga
        $("#jml-beli").on('keyup',function(){
           let harga = $("#harga-brg").val();
           let total = harga * $(this).val();
            $("#total-harga").val(total);
        });

        

        // Fungsi Menambah data ke tabel
        $("#btn-beli").on('click',function(){
            let kd_brg = $(".cari-barang").val();
            let cek = $("#table-transaksi").find(`.kd-${kd_brg}`);
            $("#total-bayar").show();
            $(".pembayaran").removeAttr('disabled');
            if(cek.length < 1){
                no+=1;
                // const nama_brg = $("#nama-brg").val();
                // const harga = $("#harga-brg").val();
                const val_inp = $(".tampil-barang :input").serializeArray();
                const [nama_brg,harga,jumlah,total] = val_inp;
                $("table tbody").last().before(`
                    <tr class="kd-${kd_brg}">
                        <td>${no}</td>
                        <td>${nama_brg.value}</td>
                        <td>${harga.value}</td>
                        <td>${jumlah.value}</td>
                        <td>${total.value}</td>
                        <td>
                                <button class="btn btn-danger btn-icon hapus-pembelian" data-id="${kd_brg}"><i class="fas fa-trash"></i></button>
                          </td>
                    </tr>
                `);
                total_bayar += total.value*1;
                $(".cari-barang").val(null).trigger('change');
                $(":input").val("");
                list_barang.push({
                        kode_barang:kd_brg,
                        harga:harga.value,
                        qty:jumlah.value,
                    });
                
                console.log(val_inp);
            }else{
                console.log('Data sudah ada');
            }
            $("#total-bayar td:nth-child(2)").text(total_bayar);
            // $("#total-hrg").val(total_bayar);
            // $("table tbody").last().before("<tr><td>"+no+"</td></tr>");
            

        });


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
        });

        $('#exampleModal').on('hidden.bs.modal', function (event) {
            $('.form-bayar').find(":input").val("");
            $("#keterangan").val("");
        });

        $(".bayar-transaksi").on("click",function(){
            data._token = _token;
            data.barang = list_barang;
            data.total_harga = total_bayar;
            data.keterangan = $("#keterangan").val();
            console.log(data);
            $.ajax({
                url:"{{route('transaksi.store')}}",
                method : "POST",
                data : data,
                dataType:"json",
                success:function(res){
                    if(res.code == 200){
                        swal({
                            title: 'Pesan',
                            text: `${res.message}`,
                            icon: 'success',
                            closeOnClickOutside: false
                            }).then(()=>location.reload());
                    }
                },
                error:function(err){
                    console.log(err);
                }
            })
        });

        $("table").on('click','.hapus-pembelian',function(){
            let baris = $(this).closest('tr');
            let id = $(this).attr('data-id');
            let total = baris.find('td:nth-child(5)').text();
            let baris_totalAll = $("#total-bayar").find('td:nth-child(2)');
            total_bayar = baris_totalAll.text()*1 - total*1;
            for(let i=0;i<list_barang.length;i++){
                if(list_barang[i].kode_barang == id){
                    list_barang.splice(i,1);
                }
            }           
           baris.remove();
           coba();
        });

       });
        // backup code
        //    <a class="btn btn-info btn-icon btn-qty"  data-id="${kd_brg}"><i class="fas fa-pencil-alt"></i></a>      
    </script>
@endpush
