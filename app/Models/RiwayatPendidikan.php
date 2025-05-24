<?php

namespace App\Models;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPendidikan extends Model
{
    // Nama tabel
    protected $table = 'riwayat_pendidikan';

    // Primary key
    protected $primaryKey = 'id_pendidikan';

    // Disable timestamps jika tidak ada kolom created_at dan updated_at
    public $timestamps = false;

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'nip',
        'jenjang',
        'prodi',
        'tahun_masuk',
        'tahun_keluar',
    ];

    /**
     * Relasi ke model Dosen (jika ada model Dosen)
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }
}
