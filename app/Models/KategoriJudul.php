<?php

namespace App\Models;

use App\Models\PengajuanJudul;
use Illuminate\Database\Eloquent\Model;

class KategoriJudul extends Model
{
    protected $primaryKey = 'kd_kategori';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function pengajuanJudul()
    {
        return $this->hasMany(PengajuanJudul::class, 'kd_kategori');
    }
}