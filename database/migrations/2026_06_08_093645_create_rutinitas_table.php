<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rutinitas', function (Blueprint $table) {
            $table->bigIncrements('id_rutinitas');
            $table->unsignedBigInteger('id_tugas');
            $table->time('jam');
            $table->boolean('aktif')->default(true);

            $table->foreign('id_tugas')->references('id_tugas')->on('tugas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rutinitas');
    }
};
