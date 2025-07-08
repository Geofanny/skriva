<?php

namespace App\Http\Controllers\pembimbing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function daftarMahasiswa()
    {
        $nip = Auth::guard('pembimbing')->user()->nip;

        $kdPembimbingList = DB::table('pembimbing')
        ->where('nip', $nip)
        ->pluck('kd_pembimbing');
    
        // Ambil list nama mahasiswa untuk dropdown
        $mahasiswa = DB::table('pembimbing_mahasiswa')
        ->join('mahasiswa', 'mahasiswa.npm', '=', 'pembimbing_mahasiswa.npm')
        ->whereIn('pembimbing_mahasiswa.kd_pembimbing', $kdPembimbingList)
        ->select('mahasiswa.npm', 'mahasiswa.nama')
        ->distinct()
        ->get();


        // dd($mahasiswa);
        // die;
    
        // Ambil mahasiswa yang dibimbing + total bimbingan disetujui + total ditolak
        $monitoring = DB::table('pembimbing_mahasiswa')
        ->join('mahasiswa', 'mahasiswa.npm', '=', 'pembimbing_mahasiswa.npm')
        ->leftJoin('skripsi', 'skripsi.npm', '=', 'mahasiswa.npm')
        ->leftJoin('sesi_bimbingan', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
    
        // Hitung yang Disetujui
        ->leftJoin('bimbingan_dosen as bd_setuju', function ($join) use ($kdPembimbingList) {
            $join->on('bd_setuju.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
                 ->whereIn('bd_setuju.kd_pembimbing', $kdPembimbingList)
                 ->where('bd_setuju.status', '=', 'Disetujui');
        })
    
        // Hitung yang Ditolak
        ->leftJoin('bimbingan_dosen as bd_tolak', function ($join) use ($kdPembimbingList) {
            $join->on('bd_tolak.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
                 ->whereIn('bd_tolak.kd_pembimbing', $kdPembimbingList)
                 ->where('bd_tolak.status', '=', 'Ditolak');
        })
    
        ->whereIn('pembimbing_mahasiswa.kd_pembimbing', $kdPembimbingList)
    
        ->select(
            'mahasiswa.npm',
            'mahasiswa.nama',
            'skripsi.kategori',
            'skripsi.judul',
            DB::raw('COUNT(DISTINCT bd_setuju.kd_bimbingan) as jumlah_bimbingan'),
            DB::raw('COUNT(DISTINCT bd_tolak.kd_bimbingan) as jumlah_ditolak')
        )
        ->groupBy('mahasiswa.npm', 'mahasiswa.nama', 'skripsi.kategori', 'skripsi.judul')
        ->get();
    

        // dd($monitoring);
        // die;
    
        return view('pembimbing.daftarMahasiswa', compact('mahasiswa', 'monitoring'));
    }
    

    public function filterMahasiswa(Request $request)
    {
        $nip = Auth::guard('pembimbing')->user()->nip;

        // Ambil semua kd_pembimbing milik dosen ini
        $kdPembimbingList = DB::table('pembimbing')
        ->where('nip', $nip)
        ->pluck('kd_pembimbing');
    
        $query = DB::table('pembimbing_mahasiswa')
        ->join('mahasiswa', 'mahasiswa.npm', '=', 'pembimbing_mahasiswa.npm')
        ->leftJoin('skripsi', 'skripsi.npm', '=', 'mahasiswa.npm')
        ->leftJoin('sesi_bimbingan', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')

        // Hitung Disetujui
        ->leftJoin('bimbingan_dosen as bd_setuju', function ($join) use ($kdPembimbingList) {
            $join->on('bd_setuju.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
                 ->whereIn('bd_setuju.kd_pembimbing', $kdPembimbingList)
                 ->where('bd_setuju.status', '=', 'Disetujui');
        })

        // Hitung Ditolak
        ->leftJoin('bimbingan_dosen as bd_tolak', function ($join) use ($kdPembimbingList) {
            $join->on('bd_tolak.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
                 ->whereIn('bd_tolak.kd_pembimbing', $kdPembimbingList)
                 ->where('bd_tolak.status', '=', 'Ditolak');
        })

        ->whereIn('pembimbing_mahasiswa.kd_pembimbing', $kdPembimbingList)

        ->select(
            'mahasiswa.npm',
            'mahasiswa.nama',
            'skripsi.kategori',
            'skripsi.judul',
            DB::raw('COUNT(DISTINCT bd_setuju.kd_bimbingan) as jumlah_bimbingan'),
            DB::raw('COUNT(DISTINCT bd_tolak.kd_bimbingan) as jumlah_ditolak')
        )
        ->groupBy('mahasiswa.npm', 'mahasiswa.nama', 'skripsi.kategori', 'skripsi.judul');

        // Filter berdasarkan inputan user
        if ($request->npm) {
            $query->where('mahasiswa.npm', $request->npm);
        }

        if ($request->kategori) {
            $query->where('skripsi.kategori', $request->kategori);
        }
    
        return response()->json(['data' => $query->get()]);
    }
    
    
    

}
