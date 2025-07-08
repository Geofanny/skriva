<?php

namespace App\Models;

use App\Models\JudulAjuan;
use App\Models\Pembimbing;
use Illuminate\Database\Eloquent\Model;

class PenilaianJudul extends Model
{
    protected $primaryKey = 'kd_judul';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function judul()
    {
        return $this->belongsTo(JudulAjuan::class, 'kd_judul');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'kd_pembimbing');
    }
}

