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
            $table->string('tanggal')->nullable();
            $table->string('gambar', 300)->nullable();
            $table->string('serialnumber')->nullable();
            $table->string('device')->nullable();
            $table->string('customer')->nullable();
            $table->string('telp')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('kelengkapankirim')->nullable();
            $table->string('tanggalkembali')->nullable();
            $table->string('penerima')->nullable();
            $table->string('kelengkapankembali')->nullable();
            $table->boolean('status')->default('1')->nullable();
            // $table->enum('status', ['0', '1'])->default('0');
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
