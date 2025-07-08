<?php

namespace App\Models;

use App\Models\Prodi;
use App\Models\Pembimbing;
use App\Models\KoordinasiTA;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    use HasFactory;

    protected $table = 'dosen'; // opsional jika sesuai konvensi Laravel
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // protected $with = ['prodi'];

    protected $fillable = [
        'nip',
        'nama',
        'foto',
        'password',
        'kd_prodi',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kd_prodi');
    }

    public function pembimbing()
    {
        return $this->hasMany(Pembimbing::class, 'nip');
    }

    public function koordinasiTA()
    {
        return $this->hasMany(KoordinasiTA::class, 'nip');
    }
}

