<?php

namespace App\Models;

use App\Models\DaftarBimbingan;
use App\Models\RiwayatPendidikan;
// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'dosen';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nip', 'nama', 'token', 'prodi','password','no_hp','foto'];

    public function daftarBimbingan()
    {
        return $this->hasMany(DaftarBimbingan::class, 'nip', 'nip');
    }

    public function riwayatPendidikan()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'nip', 'nip');
    }

}
