<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konseling_kels', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kasus');
            $table->text('solusi')->nullable();
            $table->timestamps();
        });

        Schema::create('konseling_kelompok', function (Blueprint $table) {
            $table->foreignId('konseling_kel_id')->references('id')->on('konseling_kels')->cascadeOnDelete();
            $table->foreignId('siswa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling_kels');
        Schema::dropIfExists('konseling_kelompok');
    }
};
