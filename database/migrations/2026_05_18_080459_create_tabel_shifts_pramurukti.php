<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts_pramurukti', function (Blueprint $table) {
            $table->bigIncrements('id_shift_harian');
            $table->unsignedBigInteger('id_shift');
            $table->unsignedBigInteger('id_pramurukti');
            $table->date('tanggal');

            $table->foreign('id_shift')->references('id_shift')->on('shifts');
            $table->foreign('id_pramurukti')->references('id_pramurukti')->on('pramurukti');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts_pramurukti');
    }
};