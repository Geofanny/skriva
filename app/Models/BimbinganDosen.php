<?php

namespace App\Models;

use App\Models\Pembimbing;
use App\Models\SesiBimbingan;
use Illuminate\Database\Eloquent\Model;

class BimbinganDosen extends Model
{
    protected $primaryKey = 'kd_bimbingan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function sesi()
    {
        return $this->belongsTo(SesiBimbingan::class, 'kd_sesi');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'kd_pembimbing');
    }
}

