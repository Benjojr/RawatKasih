<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pramurukti', function (Blueprint $table) {
            $table->bigIncrements('id_pramurukti');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_tugas_harian')->nullable();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
            $table->foreign('id_tugas_harian')->references('id_tugas_harian')->on('tugas_harian');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pramurukti');
    }
};