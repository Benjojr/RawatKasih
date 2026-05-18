<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->bigIncrements('id_pengguna');
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('peran', ['admin', 'pramurukti', 'keluarga']);
            $table->string('no_telpon', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};