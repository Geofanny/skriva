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
        Schema::create('pengajuan_judul', function (Blueprint $table) {
            $table->string('kd_pengajuan',7)->primary(); //P + 3 DIGIT MHS + 001
            $table->date('tgl_ajuan');
            $table->string('npm',13);
            $table->foreign('npm')->references('npm')->on('mahasiswa')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('kd_kategori',5);
            $table->foreign('kd_kategori')->references('kd_kategori')->on('kategori_judul')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koordinasi_pengajuan_judul');
    }
};
