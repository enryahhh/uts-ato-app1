<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_jenis_barang', function (Blueprint $table) {
            $table->bigIncrements("id_jenis");
            $table->string("nama_jenis",30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('tb_barang')) {
            Schema::drop('tb_barang');
        }
        Schema::dropIfExists('tb_jenis_barang');
    }
}
