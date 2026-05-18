<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->bigIncrements('id_kunjungan');
            $table->unsignedBigInteger('id_keluarga');
            $table->unsignedBigInteger('id_penghuni');
            $table->integer('jam_kunjungan');
            $table->date('tanggal_kunjungan');
            $table->enum('status_kunjungan', ['mendatang', 'tuntas'])->default('mendatang');
            $table->string('catatan', 300)->nullable();

            $table->foreign('id_keluarga')->references('id_keluarga')->on('keluarga');
            $table->foreign('id_penghuni')->references('id_penghuni')->on('penghuni');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};