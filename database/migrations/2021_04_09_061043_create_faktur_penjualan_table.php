<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakturPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faktur_penjualan', function (Blueprint $table) {
            $table->id('no_faktur');
            $table->foreignId('no_service');
            $table->date('tgl_faktur');
            $table->date('tgl_segel_toko');
            $table->string('ketentuan');
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
        Schema::dropIfExists('faktur_penjualan');
    }
}
