<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep_obat', function (Blueprint $table) {
            $table->bigIncrements('id_resep');
            $table->unsignedBigInteger('id_obat');
            $table->string('deskripsi', 50)->nullable();

            $table->foreign('id_obat')->references('id_obat')->on('obat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_obat');
    }
};