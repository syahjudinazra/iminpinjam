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
        Schema::create('service_dones', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('serialnumber');
            $table->string('pelanggan');
            $table->string('model');
            $table->string('ram')->nullable();
            $table->string('android')->nullable();
            $table->string('garansi')->nullable();
            $table->string('kerusakan');
            $table->boolean('kerusakanbawaan')->default(0);
            $table->string('teknisi');
            $table->text('perbaikan');
            $table->string('snkanibal');
            $table->string('nosparepart');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('dones');
    }
};
