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
        Schema::create('sesi_bimbingan', function (Blueprint $table) {
            $table->string('kd_sesi',6)->primary(); // SSI001
            $table->string('npm',13);
            $table->foreign('npm')->references('npm')->on('mahasiswa')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('topik',100);
            $table->time('waktu_mulai');
            $table->date('tgl_ajuan');
            $table->time('waktu_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_bimbingan');
    }
};
