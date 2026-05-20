<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->bigIncrements('id_notifikasi');
            $table->unsignedBigInteger('id_pengguna');
            $table->string('judul', 100);
            $table->string('pesan', 300);
            $table->string('tipe', 30)->default('info'); // info, warning, success
            $table->boolean('dibaca')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};