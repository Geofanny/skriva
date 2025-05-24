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
        Schema::create('riwayat_pendidikan', function (Blueprint $table) {
            $table->id('id_pendidikan');
            $table->string('nip', 16);
            $table->foreign('nip')->references('nip')->on('dosen')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('jenjang',20);
            $table->string('prodi',60);
            $table->year('tahun_masuk');
            $table->year('tahun_keluar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendidikan');
    }
};
