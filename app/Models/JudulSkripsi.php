<?php

namespace App\Models;

use App\Models\JudulAjuan;
use Illuminate\Database\Eloquent\Model;

class JudulSkripsi extends Model
{
    protected $primaryKey = 'kd_skripsi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function judul()
    {
        return $this->belongsTo(JudulAjuan::class, 'kd_judul');
    }
}

