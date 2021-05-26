<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->char('id_transaksi',12)->primary();
            $table->date('tgl_transaksi');
            $table->double('total_harga');
            $table->double('total_bayar');
            $table->text('keterangan');
            $table->timestamps();
        });

        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->foreignId('id_user')->after("id_transaksi")->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
        
        if (Schema::hasTable('tb_detail_transaksi')) {
            Schema::drop('tb_detail_transaksi');
        }
        Schema::dropIfExists('tb_transaksi');
    }
}
