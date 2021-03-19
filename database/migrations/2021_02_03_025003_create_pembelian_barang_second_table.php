<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianBarangSecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_barang_second', function (Blueprint $table) {
            $table->foreignId('no_service');
            $table->string('nama_toko_asal')->nullable();
            $table->double('harga_beli', 15, 0)->nullable();
            $table->double('pengajuan_harga', 15, 0)->nullable();
            $table->string('lama_pemakaian')->nullable();
            $table->date('segel_distri')->nullable();
            $table->date('tanggal_pembelian')->nullable();
            $table->string('alasan_menjual')->nullable();
            $table->foreignId('id_teknisi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('processor')->nullable();
            $table->string('memory')->nullable();
            $table->string('harddisk')->nullable();
            $table->string('graphic_card')->nullable();
            $table->boolean('cd_dvd')->default(0);
            $table->boolean('keyboard')->default(0);
            $table->boolean('lcd')->default(0);
            $table->boolean('usb')->default(0);
            $table->boolean('camera')->default(0);
            $table->boolean('charger')->default(0);
            $table->boolean('casing')->default(0);
            $table->boolean('touchpad')->default(0);
            $table->boolean('wifi')->default(0);
            $table->boolean('lan')->default(0);
            $table->boolean('sound')->default(0);
            $table->boolean('baterai')->default(0);
            $table->boolean('nota')->default(0);
            $table->boolean('kotak')->default(0);
            $table->boolean('tas')->default(0);
            $table->boolean('dibeli')->nullable();
            $table->boolean('kode_jual')->nullable(); // 0 Tukar Tambah, 1 Jual aja
            $table->double('nominal', 15, 0)->nullable();
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
        Schema::dropIfExists('pembelian_barang_second');
    }
}
