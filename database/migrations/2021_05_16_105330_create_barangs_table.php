<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;


class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->char('kode_barang',7)->primary();
            $table->string('nama_barang',40);
            $table->string('satuan',15);
            $table->string('foto');
            $table->double('harga');
            $table->integer('stok');
            $table->timestamps();
        });

        Schema::table('tb_barang', function (Blueprint $table) {
            $table->foreignId('id_jenis')->after("stok")->constrained('tb_jenis_barang','id_jenis');
        });

        Schema::table('tb_barang', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_barang', function (Blueprint $table) {
            $table->dropForeign(['id_jenis']);
        });
        Schema::dropIfExists('tb_barang');
        
    }
}
