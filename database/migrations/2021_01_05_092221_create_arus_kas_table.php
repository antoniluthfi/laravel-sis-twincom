<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArusKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arus_kas', function (Blueprint $table) {
            $table->id('no_bukti');
            $table->foreignId('no_pembayaran')->default(0);
            $table->foreignId('no_service')->default(0);
            $table->foreignId('no_pengembalian')->default(0);
            $table->string('norekening', 50);
            $table->boolean('kas');
            $table->boolean('dp');
            $table->double('nominal', 15, 0);
            $table->boolean('masuk')->default(false);
            $table->boolean('keluar')->default(false);
            $table->foreignId('id_admin');
            $table->foreignId('id_sandi');
            $table->string('keterangan');
            $table->string('cabang');
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
        Schema::dropIfExists('arus_kas');
    }
}
