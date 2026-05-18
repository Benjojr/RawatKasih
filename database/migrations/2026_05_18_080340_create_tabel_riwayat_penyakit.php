<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_penyakit', function (Blueprint $table) {
            $table->bigIncrements('id_riwayat_penyakit');
            $table->unsignedBigInteger('id_penyakit')->nullable();

            $table->foreign('id_penyakit')->references('id_penyakit')->on('penyakit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_penyakit');
    }
};