<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_barang', function (Blueprint $table) {
            $table->id('no_service_penerimaan');
            $table->string('jenis_penerimaan', 50);
            $table->foreignId('id_cabang');
            $table->foreignId('id_customer');
            $table->foreignId('id_bj');
            $table->foreignId('id_admin');
            $table->foreignId('no_faktur')->nullable();
            $table->string('merek')->nullable();
            $table->string('tipe')->nullable();
            $table->string('sn')->nullable();
            $table->string('kelengkapan')->nullable();
            $table->string('problem')->nullable();
            $table->string('kondisi')->nullable();
            $table->boolean('data_penting')->default(false);
            $table->boolean('cek_stiker')->default(false);
            $table->string('permintaan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('estimasi', 20);
            $table->boolean('status_garansi')->default(0);
            $table->string('nama_garansi')->nullable();
            $table->integer('sisa_garansi')->nullable();
            $table->boolean('layanan')->default(false);
            $table->string('link_video')->nullable();
            $table->dateTime('tempo');
            $table->string('rma')->nullable();
            $table->boolean('shift')->default(false);
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
        Schema::dropIfExists('penerimaan_barang');
    }
}
