<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\JudulAjuan;
use App\Models\KategoriJudul;
use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{
    protected $primaryKey = 'kd_pengajuan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'npm');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriJudul::class, 'kd_kategori');
    }

    public function judul()
    {
        return $this->hasMany(JudulAjuan::class, 'kd_pengajuan');
    }
}

