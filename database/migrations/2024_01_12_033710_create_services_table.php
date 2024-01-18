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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('serialnumber');
            $table->date('tanggalmasuk');
            $table->date('tanggalkeluar')->nullable();
            $table->enum('pemilik', ['stock', 'customer']);
            $table->enum('status', ['pending', 'validasi', 'selesai'])->default('pending');
            $table->string('pelanggan');
            $table->string('device');
            $table->string('pemakaian');
            $table->string('kerusakan');
            $table->string('perbaikan')->nullable();
            $table->string('nosparepart')->nullable();
            $table->string('snkanibal')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('catatan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
