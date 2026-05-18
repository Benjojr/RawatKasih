<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas_harian', function (Blueprint $table) {
            $table->bigIncrements('id_tugas_harian');
            $table->unsignedBigInteger('id_penghuni');
            $table->unsignedBigInteger('id_tugas');
            $table->string('catatan', 300)->nullable();
            $table->time('waktu_pelaksanaan');
            $table->enum('status_tugas', ['mendatang', 'in progress', 'tuntas'])->default('mendatang');
            $table->enum('mood', ['baik', 'biasa', 'kurang baik', 'buruk']);

            $table->foreign('id_penghuni')->references('id_penghuni')->on('penghuni');
            $table->foreign('id_tugas')->references('id_tugas')->on('tugas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas_harian');
    }
};