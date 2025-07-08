<?php

namespace App\Models;

use App\Models\Prodi;
use App\Models\Pembimbing;
use App\Models\SesiBimbingan;
use App\Models\PengajuanJudul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'npm',
        'nama',
        'password',
        'foto',
        'kd_prodi',
    ];

    // Eager load otomatis prodi dan pengajuan judul
    // protected $with = ['prodi', 'pengajuanJudul'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kd_prodi');
    }

    public function pengajuanJudul()
    {
        return $this->hasMany(PengajuanJudul::class, 'npm');
    }

    public function sesiBimbingan()
    {
        return $this->hasMany(SesiBimbingan::class, 'npm');
    }

    public function pembimbing()
    {
        return $this->belongsToMany(Pembimbing::class, 'pembimbing_mahasiswa', 'npm', 'kd_pembimbing');
    }
}

