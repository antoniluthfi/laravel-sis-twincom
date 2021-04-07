<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangJasaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_jasa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bj');
            $table->tinyInteger('jenis');
            $table->boolean('form_data_penting');
            $table->boolean('merek_dan_tipe');
            $table->boolean('sn');
            $table->boolean('stiker');
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
        Schema::dropIfExists('barang_jasa');
    }
}
