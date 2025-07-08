<?php

namespace App\Http\Controllers\koordinasi;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MonitoringController extends Controller
{
    public function index()
    {
        $nipKoor = auth('koordinator')->user()->nip;

        // Ambil kd_prodi dari dosen yang login sebagai koordinator
        $kd_prodi_koor = DB::table('dosen')
            ->where('nip', $nipKoor)
            ->value('kd_prodi');
    
        // Ambil nama fakultas dari prodi tersebut
        $fakultas = DB::table('prodi')
            ->where('kd_prodi', $kd_prodi_koor)
            ->value('fakultas');
    
        // Ambil semua kd_prodi dari fakultas tersebut
        $kd_prodiList = DB::table('prodi')
            ->where('fakultas', $fakultas)
            ->pluck('kd_prodi');
        
        // dd($kd_prodiList);
        // die;

        // Ambil data sesi bimbingan berdasarkan prodi yang ada di fakultas koordinator login
        $sesiBimbingan = DB::table('sesi_bimbingan')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->join('prodi', 'mahasiswa.kd_prodi', '=', 'prodi.kd_prodi')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('bimbingan_dosen.status', 'Disetujui')
            ->whereIn('mahasiswa.kd_prodi', $kd_prodiList) // hanya prodi koordinator login
            ->select(
                'sesi_bimbingan.kd_sesi',
                'sesi_bimbingan.npm',
                'mahasiswa.nama',
                'prodi.nama_prodi',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'sesi_bimbingan.tgl_ajuan',
                DB::raw('GROUP_CONCAT(DISTINCT dosen.nama SEPARATOR ", ") as nama_pembimbing')
            )
            ->groupBy(
                'sesi_bimbingan.kd_sesi',
                'sesi_bimbingan.npm',
                'mahasiswa.nama',
                'prodi.nama_prodi',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'sesi_bimbingan.tgl_ajuan'
            )
            ->orderByDesc('sesi_bimbingan.tgl_ajuan')
            // ->get();
            ->paginate(10);

        //     dd($sesiBimbingan);
        // die;

        return view('koordinasi.bimbingan', compact('sesiBimbingan'));
    }

    public function getData(Request $request)
    {
        $nipKoor = auth('koordinator')->user()->nip;

        // Ambil kd_prodi dari dosen yang login sebagai koordinator
        $kd_prodi_koor = DB::table('dosen')
            ->where('nip', $nipKoor)
            ->value('kd_prodi');
    
        // Ambil nama fakultas dari prodi tersebut
        $fakultas = DB::table('prodi')
            ->where('kd_prodi', $kd_prodi_koor)
            ->value('fakultas');
    
        // Ambil semua kd_prodi dari fakultas tersebut
        $kd_prodiList = DB::table('prodi')
            ->where('fakultas', $fakultas)
            ->pluck('kd_prodi');

        $query = DB::table('sesi_bimbingan')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->join('prodi', 'mahasiswa.kd_prodi', '=', 'prodi.kd_prodi')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('bimbingan_dosen.status', 'Disetujui')
            ->whereIn('mahasiswa.kd_prodi', $kd_prodiList)
            ->select(
                'sesi_bimbingan.kd_sesi',
                'sesi_bimbingan.npm',
                'mahasiswa.nama',
                'prodi.nama_prodi',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'sesi_bimbingan.tgl_ajuan',
                DB::raw('GROUP_CONCAT(dosen.nama SEPARATOR ", ") as nama_pembimbing')
            );

        // Filter bulan
        if ($request->bulan) {
            $query->whereMonth('sesi_bimbingan.tgl_ajuan', $request->bulan);
        }

        // Filter tahun
        if ($request->tahun) {
            $query->whereYear('sesi_bimbingan.tgl_ajuan', $request->tahun);
        }

        // Grouping dan order (harus setelah filter)
        $results = $query
            ->groupBy(
                'sesi_bimbingan.kd_sesi',
                'sesi_bimbingan.npm',
                'mahasiswa.nama',
                'prodi.nama_prodi',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'sesi_bimbingan.tgl_ajuan'
            )
            ->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')
            ->paginate(10);

        return response()->json([
            'html' => view('koordinasi.filterData', compact('results'))->render()
        ]);
    }

    public function getPembimbingByProdi($kd_prodi)
    {
        $pembimbing = DB::table('pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('dosen.kd_prodi', $kd_prodi)
            ->selectRaw('MIN(pembimbing.kd_pembimbing) as kd_pembimbing, dosen.nip, dosen.nama')
            ->groupBy('dosen.nip', 'dosen.nama')
            ->get();
    
        return response()->json($pembimbing);
    }    

    public function exportPDF(Request $request)
    {
        $nipKoor = auth('koordinator')->user()->nip;

        // Ambil kd_prodi dari dosen yang login sebagai koordinator
        $kd_prodi_koor = DB::table('dosen')
            ->where('nip', $nipKoor)
            ->value('kd_prodi');
    
        // Ambil nama fakultas dari prodi tersebut
        $fakultas = DB::table('prodi')
            ->where('kd_prodi', $kd_prodi_koor)
            ->value('fakultas');
    
        // Ambil semua kd_prodi dari fakultas tersebut
        $kd_prodiList = DB::table('prodi')
            ->where('fakultas', $fakultas)
            ->pluck('kd_prodi');

        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $sesiBimbingan = DB::table('sesi_bimbingan')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->join('prodi', 'mahasiswa.kd_prodi', '=', 'prodi.kd_prodi')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('bimbingan_dosen.status', 'Disetujui')
            ->whereIn('mahasiswa.kd_prodi', $kd_prodiList)
            ->whereMonth('sesi_bimbingan.tgl_ajuan', $bulan)
            ->whereYear('sesi_bimbingan.tgl_ajuan', $tahun)
            ->select(
                'sesi_bimbingan.kd_sesi',
                'sesi_bimbingan.npm',
                'mahasiswa.nama',
                'prodi.nama_prodi',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'sesi_bimbingan.tgl_ajuan',
                DB::raw('GROUP_CONCAT(DISTINCT dosen.nama SEPARATOR ", ") as nama_pembimbing')
            )
            ->groupBy(
                'sesi_bimbingan.kd_sesi',
                'sesi_bimbingan.npm',
                'mahasiswa.nama',
                'prodi.nama_prodi',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'sesi_bimbingan.tgl_ajuan'
            )
            ->orderByDesc('sesi_bimbingan.tgl_ajuan')
            ->get();

            $koordinasi = DB::table('koordinasi_ta')
            ->join('dosen', 'koordinasi_ta.nip', '=', 'dosen.nip')
            ->join('prodi', 'koordinasi_ta.kd_prodi', '=', 'prodi.kd_prodi')
            ->select(
                'dosen.nama',
                'dosen.nip',
                'prodi.fakultas'
            )
            ->where('koordinasi_ta.nip', auth('koordinator')->user()->nip)
            ->first();


        $pdf = Pdf::loadView('koordinasi/laporanBimbingan', compact('sesiBimbingan', 'bulan', 'tahun','koordinasi'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-monitoring-bimbingan.pdf');
    }
}
