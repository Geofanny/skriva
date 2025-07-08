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
        Schema::create('bimbingan_dosen', function (Blueprint $table) {
            $table->string('kd_bimbingan',6)->primary(); // BIM001
            $table->string('kd_pembimbing',10);
            $table->foreign('kd_pembimbing')->references('kd_pembimbing')->on('pembimbing')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->text('komentar_penolakan');
            $table->string('status');
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
        Schema::dropIfExists('bimbingan_dosen');
    }
};
