<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->bigIncrements('id_tugas');
            $table->string('judul_tugas', 100)->nullable();
            $table->enum('tipe_tugas', ['aktifitas', 'monitoring', 'obat']);
            $table->boolean('butuh_vital')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};