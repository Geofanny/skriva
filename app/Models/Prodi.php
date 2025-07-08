<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\KoordinasiTA;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'kd_prodi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_prodi',
        'nama_prodi',
        'fakultas',
    ];

    protected $with = ['mahasiswa', 'dosen'];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'kd_prodi');
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'kd_prodi');
    }

    public function koordinasiTA()
    {
        return $this->hasMany(KoordinasiTA::class, 'kd_prodi');
    }
}

