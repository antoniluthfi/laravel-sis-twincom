<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListKelengkapanPenerimaanBarangServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_kelengkapan_penerimaan_barang_service', function (Blueprint $table) {
            $table->foreignId('no_service');
            $table->string('kelengkapan');
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
        Schema::dropIfExists('list_kelengkapan_penerimaan_barang_service');
    }
}
