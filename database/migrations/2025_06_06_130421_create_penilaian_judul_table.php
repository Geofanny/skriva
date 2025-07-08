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
        Schema::create('penilaian_judul', function (Blueprint $table) {
            $table->string('kd_pembimbing',8);
            $table->foreign('kd_pembimbing')->references('kd_pembimbing')->on('pembimbing')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('kd_judul',6)->primary();
            $table->foreign('kd_judul')->references('kd_judul')->on('judul_ajuan')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->text('komentar');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_judul');
    }
};
