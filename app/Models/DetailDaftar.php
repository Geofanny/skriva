<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\DaftarBimbingan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailDaftar extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'detail_daftar';
    public $incrementing = false;

    protected $fillable = ['kd_bimbingan', 'npm'];

    /**
     * Relasi ke tabel DaftarBimbingan
     */
    public function bimbingan()
    {
        return $this->belongsTo(DaftarBimbingan::class, 'kd_bimbingan', 'kd_bimbingan');
    }

    /**
     * Relasi ke tabel Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'npm', 'npm');
    }
}
