<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengerjaan', function (Blueprint $table) {
            $table->id('no_pengerjaan');
            $table->foreignId('no_service');
            $table->foreignId('id_partner')->nullable();
            $table->double('biaya_service', 15, 0)->default(0);
            $table->tinyInteger('status_pengerjaan')->default(0);
            $table->string('alasan_batal')->nullable();
            $table->double('harga_beli', 15, 0)->nullable();
            $table->string('alasan_tidak_beli')->nullable();
            $table->boolean('cek_stiker')->nullable();
            $table->integer('garansi')->default(0);
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
        Schema::dropIfExists('pengerjaan');
    }
}
