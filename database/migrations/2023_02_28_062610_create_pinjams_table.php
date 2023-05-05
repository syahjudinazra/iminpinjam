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
        Schema::create('pinjams', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->string('gambar', 300)->nullable();
            $table->string('serialnumber')->nullable();
            $table->string('device')->nullable();
            $table->string('ram')->nullable();
            $table->string('android')->nullable();
            $table->string('customer')->nullable();
            $table->string('alamat')->nullable();
            $table->string('sales')->nullable();
            $table->string('telp')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('kelengkapankirim')->nullable();
            $table->string('tanggalkembali')->nullable();
            $table->string('penerima')->nullable();
            $table->string('kelengkapankembali')->nullable();
            $table->string('status')->default('0');
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
        Schema::dropIfExists('pinjams');
    }
};
