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
        Schema::create('kanibals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('serialnumber');
            $table->string('pelanggan');
            $table->string('model');
            $table->string('ram');
            $table->string('android');
            $table->string('garansi');
            $table->string('kerusakan');
            $table->string('teknisi');
            $table->string('perbaikan');
            $table->string('snkanibal');
            $table->string('nosparepart');
            $table->string('note');
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
        Schema::dropIfExists('kanibals');
    }
};
