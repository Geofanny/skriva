<?php

namespace App\Models;

use App\Models\JudulSkripsi;
use App\Models\PengajuanJudul;
use App\Models\PenilaianJudul;
use Illuminate\Database\Eloquent\Model;

class JudulAjuan extends Model
{
    protected $primaryKey = 'kd_judul';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanJudul::class, 'kd_pengajuan');
    }

    public function penilaian()
    {
        return $this->hasOne(PenilaianJudul::class, 'kd_judul');
    }

    public function skripsi()
    {
        return $this->hasOne(JudulSkripsi::class, 'kd_judul');
    }
}

