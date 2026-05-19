<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanda_vital', function (Blueprint $table) {
            $table->bigIncrements('id_vital');
            $table->unsignedBigInteger('id_penghuni');
            $table->string('tekanan_darah', 20)->nullable();
            $table->integer('detak_jantung')->nullable();
            $table->decimal('gula_darah', 6, 2)->nullable();
            $table->decimal('suhu', 4, 1)->nullable();
            $table->date('tanggal');
            $table->time('waktu');

            $table->foreign('id_penghuni')->references('id_penghuni')->on('penghuni');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanda_vital');
    }
};