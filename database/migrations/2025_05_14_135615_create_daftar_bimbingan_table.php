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
        Schema::create('daftar_bimbingan', function (Blueprint $table) {
            $table->string('kd_bimbingan', 12)->primary();
            $table->string('nip', 18);
            $table->foreign('nip')->references('nip')->on('dosen');
            $table->string('slug',20)->unique();
            $table->char('pembimbing',1);
            $table->date('tgl_pembuatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_bimbingan');
    }
};
