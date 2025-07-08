<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skripsi', function (Blueprint $table) {
            $table->string('kd_skripsi',7)->primary(); // KS + 3 DIGIT TERAKHIR MAHASISWA + 01
            $table->string('npm',13);
            $table->string('kategori',100);
            $table->string('judul',150);
            $table->date('tgl_upload');

            $table->foreign('npm')->references('npm')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skripsi');
    }
};
