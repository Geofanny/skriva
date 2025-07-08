<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\BimbinganDosen;
use App\Models\PenilaianJudul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pembimbing extends Authenticatable
{
    use HasFactory;

    protected $table = 'pembimbing';
    protected $primaryKey = 'kd_pembimbing';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_pembimbing',
        'nip',
        'posisi',
    ];

    // Eager load otomatis relasi dosen dan mahasiswa
    // protected $with = ['dosen', 'mahasiswa'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'pembimbing_mahasiswa', 'kd_pembimbing', 'npm');
    }

    public function penilaianJudul()
    {
        return $this->hasMany(PenilaianJudul::class, 'kd_pembimbing');
    }

    public function bimbinganDosen()
    {
        return $this->hasMany(BimbinganDosen::class, 'kd_pembimbing');
    }
}

