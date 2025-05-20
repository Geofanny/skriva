<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailJudul extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'detail_judul';
    protected $primaryKey = 'kd_judul';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kd_judul', 'kd_ajuan', 'judul', 'status', 'komentar_dospem1', 'komentar_dospem2'];
}
