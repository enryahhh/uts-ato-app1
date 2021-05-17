<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->double('harga');
            $table->integer('qty');
            $table->timestamps();
        });

        Schema::table('tb_detail_transaksi', function (Blueprint $table) {
            $table->char('id_transaksi',12)->after('id_detail_transaksi');
            $table->char('kode_barang',7)->after('id_detail_transaksi');

            $table->foreign('id_transaksi')->references('id_transaksi')->on('tb_transaksi');
            $table->foreign('kode_barang')->references('kode_barang')->on('tb_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_detail_transaksi', function (Blueprint $table) {
            $table->dropForeign(['id_transaksi'],['kode_barang']);
        });
        Schema::dropIfExists('tb_detail_transaksi');
    }
}
