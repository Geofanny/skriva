<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanJudul extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'pengajuan_judul';
    protected $primaryKey = 'kd_ajuan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kd_ajuan', 'npm', 'nip_dospem_1', 'nip_dospem_2', 'tgl_pengajuan'];
}
