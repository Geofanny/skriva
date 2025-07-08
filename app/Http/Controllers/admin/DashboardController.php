<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Kartu statistik
        $totalMahasiswa = DB::table('mahasiswa')->count();
        $totalDosen = DB::table('dosen')->count();
        $totalKoordinasi = DB::table('koordinasi_ta')->count();
    
        // Data chart Line: Bimbingan Disetujui per bulan (6 bulan terakhir)
        $bulan = [];
        $jumlahBimbingan = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('m');
            $year = Carbon::now()->subMonths($i)->format('Y');
            $label = Carbon::now()->subMonths($i)->locale('id')->translatedFormat('F');
    
            $bulan[] = $label;
            $jumlah = DB::table('bimbingan_dosen')
                ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
                ->whereMonth('sesi_bimbingan.tgl_ajuan', $month)
                ->whereYear('sesi_bimbingan.tgl_ajuan', $year)
                ->where('bimbingan_dosen.status', 'Disetujui')
                ->count();
            $jumlahBimbingan[] = $jumlah;
        }
    
        // Data chart Doughnut: Jumlah prodi per fakultas
        $prodiData = DB::table('prodi')
            ->select('fakultas', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('fakultas')
            ->get();
    
        $labelFakultas = $prodiData->pluck('fakultas')->map(function ($item) {
            return 'Fakultas ' . $item;
        });
            
        $dataFakultas = $prodiData->pluck('jumlah');
    
        return view('admin.index', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalKoordinasi',
            'bulan',
            'jumlahBimbingan',
            'labelFakultas',
            'dataFakultas'
        ));
    }

    public function statistikBimbingan()
    {
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $approved = [];
        $rejected = [];
        $bimbinganPerDosen = [];
    
        // Ambil data disetujui & ditolak per bulan
        for ($i = 1; $i <= 12; $i++) {
            $approved[] = DB::table('bimbingan_dosen')
                ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
                ->where('status', 'disetujui')
                ->whereMonth('tgl_ajuan', $i)
                ->count();
    
            $rejected[] = DB::table('bimbingan_dosen')
                ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
                ->where('status', 'ditolak')
                ->whereMonth('tgl_ajuan', $i)
                ->count();
        }
    
        // Ambil jumlah bimbingan per dosen
        $dosen = DB::table('bimbingan_dosen')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->select('dosen.nama', DB::raw('count(*) as total'))
            ->groupBy('dosen.nama')
            ->get();
    
        foreach ($dosen as $item) {
            $bimbinganPerDosen['labels'][] = $item->nama;
            $bimbinganPerDosen['data'][] = $item->total;
        }
    
        return view('admin.statistik', [
            'labels' => $months,
            'dataDisetujui' => $approved,
            'dataDitolak' => $rejected,
            'dosenLabels' => $bimbinganPerDosen['labels'] ?? [],
            'dosenData' => $bimbinganPerDosen['data'] ?? [],
        ]);
    }
    
    public function profil()
    {
        return view('admin.profil');
    }
}
