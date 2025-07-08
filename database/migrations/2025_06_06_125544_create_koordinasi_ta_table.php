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
        Schema::create('koordinasi_ta', function (Blueprint $table) {
            $table->string('kd_koordinasi',8)->primary(); // KR + 6 DIGIT TERAKHIR DOSEN
            $table->string('kd_prodi',8);
            $table->foreign('kd_prodi')->references('kd_prodi')->on('prodi')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('nip',18);
            $table->foreign('nip')->references('nip')->on('dosen')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koordinasi_ta');
    }
};
