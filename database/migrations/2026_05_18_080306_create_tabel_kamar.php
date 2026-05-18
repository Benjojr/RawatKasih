<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->bigIncrements('id_kamar');
            $table->enum('status_kamar', ['tersedia', 'diisi'])->default('tersedia');
            $table->string('nomor_kamar', 10)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};