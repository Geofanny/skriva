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
        Schema::create('judul_skripsi', function (Blueprint $table) {
            $table->string('kd_skripsi',6)->primary(); //JDL + 3 DIGIT MHS
            $table->string('kd_judul',6);
            $table->foreign('kd_judul')->references('kd_judul')->on('judul_ajuan')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->date('tgl_penerimaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judul_skripsi');
    }
};
