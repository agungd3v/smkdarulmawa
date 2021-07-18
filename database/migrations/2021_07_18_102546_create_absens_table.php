<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('pelajaran_id');
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pelajaran_id')->references('id')->on('pelajarans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absens');
    }
}
