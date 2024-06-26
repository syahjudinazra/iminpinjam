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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('serialnumber');
            $table->string('tipe');
            $table->string('sku');
            $table->string('noinvoice');
            $table->date('tanggalmasuk');
            $table->date('tanggalkeluar')->nullable();
            $table->string('pelanggan')->nullable();
            $table->string('lokasi');
            $table->string('keterangan')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('stocks');
    }
};
