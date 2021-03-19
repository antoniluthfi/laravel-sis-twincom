<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_partner', function (Blueprint $table) {
            $table->foreignId('no_service');
            $table->foreignId('id_partner');
            $table->double('biaya_service', 15, 0);
            $table->double('nominal', 15, 0);
            $table->string('keterangan')->nullable();
            $table->boolean('status_pembayaran')->default(false);
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
        Schema::dropIfExists('tagihan_partner');
    }
}
