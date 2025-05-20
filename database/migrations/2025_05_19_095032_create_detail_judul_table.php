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
        Schema::create('detail_judul', function (Blueprint $table) {
            $table->string('kd_judul', 10)->primary();
            $table->string('kd_ajuan', 10);
            $table->foreign('kd_ajuan')->references('kd_ajuan')->on('pengajuan_judul')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('judul',60);
            $table->string('kategori',60);
            $table->string('status',30);
            $table->text('komentar_dospem1');
            $table->text('komentar_dospem2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_judul');
    }
};
