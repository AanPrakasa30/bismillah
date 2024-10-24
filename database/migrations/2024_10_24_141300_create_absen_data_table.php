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
        Schema::create('absen_data', function (Blueprint $table) {
            $table->id();
            $table->string('NIS');
            $table->string('name');
            $table->string('kelas');
            $table->integer('tahun_angkatan');
            $table->date('tanggal');
            $table->string('tipe');
            $table->text('keterangan');
            $table->uuid('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_data');
    }
};
