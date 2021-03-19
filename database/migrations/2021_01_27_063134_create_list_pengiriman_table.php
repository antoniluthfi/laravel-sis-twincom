<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListPengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_pengiriman', function (Blueprint $table) {
            $table->foreignId('no_surat_jalan');
            $table->foreignId('no_service');
            $table->string('kelengkapan');
            $table->string('kerusakan');
            $table->tinyInteger('status_pengiriman')->default(0);
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
        Schema::dropIfExists('list_pengiriman');
    }
}
