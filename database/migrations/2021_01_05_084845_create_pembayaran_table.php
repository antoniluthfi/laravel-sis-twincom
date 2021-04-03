<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('no_pembayaran');
            $table->foreignId('no_service');
            $table->foreignId('id_admin')->default(0);
            $table->string('norekening', 50)->nullable();
            $table->boolean('kas')->default(false);
            $table->boolean('diskon')->default(0);
            $table->string('diskon_kecewa')->nullable();
            $table->double('nominal', 15, 0)->default(0);
            $table->boolean('dp')->default(false);
            $table->string('keterangan_pembayaran')->nullable();
            $table->boolean('status_pembayaran')->default(false);
            $table->boolean('shift')->default(false);
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
        Schema::dropIfExists('pembayaran');
    }
}
