<?php

namespace App\Models;

use App\Models\SesiBimbingan;
use Illuminate\Database\Eloquent\Model;

class FileBimbingan extends Model
{
    protected $primaryKey = 'kd_file';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function sesi()
    {
        return $this->belongsTo(SesiBimbingan::class, 'kd_sesi');
    }
}

