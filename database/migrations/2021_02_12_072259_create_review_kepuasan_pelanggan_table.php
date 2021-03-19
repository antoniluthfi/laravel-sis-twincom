<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewKepuasanPelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_kepuasan_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_service');
            $table->foreignId('user_id');
            $table->string('jabatan');
            $table->string('cabang');
            $table->tinyInteger('rating')->nullable();
            $table->text('ulasan')->nullable();
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
        Schema::dropIfExists('review_kepuasan_pelanggan');
    }
}
