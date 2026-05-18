<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id_shift');
            $table->string('nama_shift', 50);
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};