<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class KoordinasiTA extends Authenticatable
{
    use HasFactory;

    protected $table = 'koordinasi_ta';
    protected $primaryKey = 'kd_koordinasi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_koordinasi',
        'kd_prodi',
        'nip',
    ];

    // Eager load default relasi prodi dan dosen
    // protected $with = ['prodi', 'dosen'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kd_prodi');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip');
    }
}

