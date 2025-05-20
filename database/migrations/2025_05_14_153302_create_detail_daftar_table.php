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
            $table->string('kd_bimbingan', 9);
            $table->foreign('kd_bimbingan')->references('kd_bimbingan')->on('daftar_bimbingan')
                  ->onDelete('cascade');
            $table->string('npm', 13);
            $table->foreign('npm')->references('npm')->on('mahasiswa');
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
