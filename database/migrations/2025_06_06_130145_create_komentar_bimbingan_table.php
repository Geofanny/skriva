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
        Schema::create('komentar_bimbingan', function (Blueprint $table) {
            $table->string('kd_komentar',6)->primary(); // KOM001
            $table->string('kd_sesi',6);
            $table->string('kd_pengguna',18);
            $table->foreign('kd_sesi')->references('kd_sesi')->on('sesi_bimbingan')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->text('isi_komentar');
            $table->timestamp('waktu_komentar')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_bimbingan');
    }
};
