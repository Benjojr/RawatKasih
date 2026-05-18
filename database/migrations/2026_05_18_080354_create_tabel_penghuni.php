<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghuni', function (Blueprint $table) {
            $table->bigIncrements('id_penghuni');
            $table->unsignedBigInteger('id_kamar')->nullable();
            $table->unsignedBigInteger('id_resep')->nullable();
            $table->unsignedBigInteger('id_riwayat_penyakit')->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('gender', 10)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->string('alamat', 100)->nullable();

            $table->foreign('id_kamar')->references('id_kamar')->on('kamar');
            $table->foreign('id_resep')->references('id_resep')->on('resep_obat');
            $table->foreign('id_riwayat_penyakit')->references('id_riwayat_penyakit')->on('riwayat_penyakit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};