<?php

namespace App\Models;

use App\Models\DaftarBimbingan;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

}
