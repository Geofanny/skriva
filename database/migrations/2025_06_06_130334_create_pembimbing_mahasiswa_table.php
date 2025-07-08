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
        Schema::create('pembimbing_mahasiswa', function (Blueprint $table) {
            $table->string('kd_pembimbing',10);
            $table->foreign('kd_pembimbing')->references('kd_pembimbing')->on('pembimbing')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('npm',13);
            $table->foreign('npm')->references('npm')->on('mahasiswa')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing_mahasiswa');
    }
};
