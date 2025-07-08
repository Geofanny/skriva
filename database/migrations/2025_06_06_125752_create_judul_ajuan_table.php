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
        Schema::create('judul_ajuan', function (Blueprint $table) {
            $table->string('kd_judul',6)->primary(); // J + 3 DIGIT MHS + 001
            $table->string('judul',100);
            $table->string('kd_pengajuan',7);
            $table->foreign('kd_pengajuan')->references('kd_pengajuan')->on('pengajuan_judul')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koordinasi_judul_ajuan');
    }
};
