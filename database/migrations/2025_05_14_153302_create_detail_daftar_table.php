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
        Schema::create('detail_daftar', function (Blueprint $table) {
            $table->string('kd_bimbingan', 12);
            $table->foreign('kd_bimbingan')->references('kd_bimbingan')->on('daftar_bimbingan')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('npm', 16);
            $table->foreign('npm')->references('npm')->on('mahasiswa')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_daftar');
    }
};
