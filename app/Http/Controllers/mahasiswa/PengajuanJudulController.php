<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengajuanJudulController extends Controller
{
    public function formulirJudul()
    {
        return view('mahasiswa.pengajuan_judul');
    }
}
