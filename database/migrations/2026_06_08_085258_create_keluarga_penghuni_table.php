<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluarga_penghuni', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_keluarga');
            $table->unsignedBigInteger('id_penghuni');
            $table->string('hubungan', 50)->nullable(); // anak, suami, istri, dll

            $table->foreign('id_keluarga')->references('id_keluarga')->on('keluarga');
            $table->foreign('id_penghuni')->references('id_penghuni')->on('penghuni');
            $table->unique(['id_keluarga', 'id_penghuni']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluarga_penghuni');
    }
};
