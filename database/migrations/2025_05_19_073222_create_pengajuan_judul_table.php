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
        Schema::create('pengajuan_judul', function (Blueprint $table) {
            $table->string('kd_ajuan', 10)->primary();
            $table->string('npm', 16);
            $table->foreign('npm')->references('npm')->on('mahasiswa');
            $table->string('nip_dospem_1', 16);
            $table->foreign('nip_dospem_1')->references('nip')->on('dosen');
            $table->string('nip_dospem_2', 16);
            $table->foreign('nip_dospem_2')->references('nip')->on('dosen');
            $table->date('tgl_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_judul');
    }
};
