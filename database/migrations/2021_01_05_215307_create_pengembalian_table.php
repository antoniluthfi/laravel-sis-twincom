<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('no_pengembalian');
            $table->foreignId('no_service');
            $table->foreignId('id_admin')->nullable();
            $table->tinyInteger('status_pengerjaan')->default(3);
            $table->boolean('cek_stiker')->nullable();
            $table->boolean('status_pembayaran')->default(false);
            $table->boolean('shift')->default(false);
            $table->string('cabang');
            $table->double('nominal', 15, 0)->default(0);
            $table->boolean('status_pengembalian')->default(false);
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
        Schema::dropIfExists('pengembalian');
    }
}
