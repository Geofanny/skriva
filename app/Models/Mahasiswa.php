<?php

namespace App\Models;

use App\Models\DetailDaftar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['npm', 'nama', 'password', 'prodi','token','foto','no_hp'];

    public function detailDaftar()
    {
        return $this->hasMany(DetailDaftar::class, 'npm', 'npm');
    }

}
