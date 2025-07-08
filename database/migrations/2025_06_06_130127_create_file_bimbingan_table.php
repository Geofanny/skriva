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
        Schema::create('file_bimbingan', function (Blueprint $table) {
            $table->string('kd_file',6)->primary(); // FLE001
            $table->string('nama_file',50);
            $table->date('tgl_upload');
            $table->string('kd_sesi',6);
            $table->foreign('kd_sesi')->references('kd_sesi')->on('sesi_bimbingan')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_bimbingan');
    }
};
