<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\FileBimbingan;
use App\Models\BimbinganDosen;
use App\Models\KomentarBimbingan;
use Illuminate\Database\Eloquent\Model;

class SesiBimbingan extends Model
{
    protected $primaryKey = 'kd_sesi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'npm');
    }

    public function file()
    {
        return $this->hasMany(FileBimbingan::class, 'kd_sesi');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarBimbingan::class, 'kd_sesi');
    }

    public function bimbinganDosen()
    {
        return $this->hasOne(BimbinganDosen::class, 'kd_sesi');
    }
}

