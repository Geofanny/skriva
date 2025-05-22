<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\DetailDaftar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaftarBimbingan extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'daftar_bimbingan';
    protected $primaryKey = 'kd_bimbingan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_bimbingan',
        'nip',
        'slug',
        'pembimbing',
        'tgl_pembuatan'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    public function detailDaftar()
    {
        return $this->hasMany(DetailDaftar::class, 'kd_bimbingan', 'kd_bimbingan');
    }

}
