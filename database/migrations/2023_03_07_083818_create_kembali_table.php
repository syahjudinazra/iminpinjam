<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kembalis', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('gambar', 300)->nullable();
            $table->string('serialnumber');
            $table->string('device');
            $table->string('customer');
            $table->string('telp');
            $table->string('pengirim');
            $table->string('kelengkapankirim');
            $table->string('tanggalkembali')->nullable();
            $table->string('penerima')->nullable();
            $table->string('kelengkapankembali')->nullable();
            $table->boolean('status')->default('1')->nullable();
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
        Schema::dropIfExists('kembali');
    }
};
