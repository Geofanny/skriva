<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\Pembimbing;
use Illuminate\Database\Eloquent\Model;

class PembimbingMahasiswa extends Model
{
    protected $table = 'pembimbing_mahasiswa';
    public $timestamps = false;

    protected $fillable = [
        'kd_pembimbing',
        'npm',
    ];

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'kd_pembimbing', 'kd_pembimbing');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'npm', 'npm');
    }
}
