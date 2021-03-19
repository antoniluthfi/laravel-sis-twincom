<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanPengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_pengiriman', function (Blueprint $table) {
            $table->foreignId('no_surat_jalan');
            $table->foreignId('no_service');
            $table->foreignId('id_partner');
            $table->foreignId('id_penerima');
            $table->boolean('status_penerimaan')->default(false);
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
        Schema::dropIfExists('penerimaan_pengiriman');
    }
}
