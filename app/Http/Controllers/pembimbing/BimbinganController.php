<?php

namespace App\Http\Controllers\pembimbing;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BimbinganController extends Controller
{
    public function daftarAjuan()
    {
        $nip = auth('pembimbing')->user()->nip;

        $ajuan = DB::table('bimbingan_dosen')
        ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
        ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
        ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
        ->where('pembimbing.nip', $nip)
        ->where('bimbingan_dosen.status', 'Menunggu')
        ->select(
            'bimbingan_dosen.kd_bimbingan',
            'mahasiswa.npm',
            'mahasiswa.nama as nama_mahasiswa',
            'sesi_bimbingan.topik',
            'sesi_bimbingan.tgl_ajuan',
            'sesi_bimbingan.waktu_mulai',
            'sesi_bimbingan.waktu_selesai'
        )
        ->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')
        ->orderBy('sesi_bimbingan.waktu_mulai', 'asc')
        ->get();
            
        // dd($ajuan);
        // die;

        return view('pembimbing.daftarAjuan', compact('ajuan'));
    }

    public function setujui($kd_bimbingan)
    {
        DB::table('bimbingan_dosen')
            ->where('kd_bimbingan', $kd_bimbingan)
            ->update([
                'status' => 'Disetujui',
                'komentar_penolakan' => '-'
            ]);

        return redirect()->back()->with('success', 'Ajuan berhasil disetujui.');
    }

    public function tolak(Request $request, $kd_bimbingan)
    {
        // dd($request->all());
        // die;
        DB::table('bimbingan_dosen')
            ->where('kd_bimbingan', $kd_bimbingan)
            ->update([
                'status' => 'Ditolak',
                'komentar_penolakan' => $request->komentar_penolakan
            ]);

        return redirect()->back()->with('success', 'Ajuan berhasil ditolak.');
    }

    public function jadwalBimbingan(Request $request)
    {
        $nip = auth('pembimbing')->user()->nip;

        $pembimbing = DB::table('pembimbing')
            ->where('nip', $nip)
            ->pluck('kd_pembimbing');
        
        $bulan = $request->query('bulan', date('n')); // default ke bulan sekarang
        $tahun = $request->query('tahun', date('Y')); // default ke tahun sekarang

        $jadwal = DB::table('bimbingan_dosen')
        ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
        ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
        ->leftJoin('file_bimbingan', 'sesi_bimbingan.kd_sesi', '=', 'file_bimbingan.kd_sesi')
        ->select(
            'bimbingan_dosen.kd_bimbingan',
            'mahasiswa.nama as nama_mahasiswa',
            'sesi_bimbingan.topik',
            'sesi_bimbingan.tgl_ajuan',
            'sesi_bimbingan.waktu_mulai',
            'sesi_bimbingan.waktu_selesai',
            'file_bimbingan.nama_file',
            'file_bimbingan.kd_file'
        )
        ->where('bimbingan_dosen.status', 'disetujui')
        ->whereIn('bimbingan_dosen.kd_pembimbing', $pembimbing)
        ->when($bulan, function($query) use ($bulan) {
            return $query->whereMonth('sesi_bimbingan.tgl_ajuan', $bulan);
        })
        ->when($tahun, function($query) use ($tahun) {
            return $query->whereYear('sesi_bimbingan.tgl_ajuan', $tahun);
        })
        ->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')
        ->get();

        return view('pembimbing.jadwalBimbingan', compact('jadwal'));
    }

    public function filterJadwal(Request $request)
    {
        $nip = auth('pembimbing')->user()->nip;

        $pembimbing = DB::table('pembimbing')
            ->where('nip', $nip)
            ->pluck('kd_pembimbing');

        $query = DB::table('bimbingan_dosen')
            ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->leftJoin('file_bimbingan', 'sesi_bimbingan.kd_sesi', '=', 'file_bimbingan.kd_sesi')
            ->select(
                'bimbingan_dosen.kd_bimbingan',
                'mahasiswa.nama as nama_mahasiswa',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.tgl_ajuan',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'file_bimbingan.nama_file',
                'file_bimbingan.kd_file'
            )
            ->where('bimbingan_dosen.status', 'disetujui')
            ->whereIn('bimbingan_dosen.kd_pembimbing', $pembimbing);

        // Filter bulan
        if ($request->bulan) {
            $query->whereMonth('sesi_bimbingan.tgl_ajuan', $request->bulan);
        }

        // Filter tahun
        if ($request->tahun) {
            $query->whereYear('sesi_bimbingan.tgl_ajuan', $request->tahun);
        }

        $jadwal = $query->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')->get();

        return response()->json($jadwal);
    }

    public function cetakJadwal(Request $request)
    {
        $nip = auth('pembimbing')->user()->nip;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $pembimbing = DB::table('pembimbing')
            ->where('nip', $nip)
            ->pluck('kd_pembimbing');

        $query = DB::table('bimbingan_dosen')
            ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->select(
                'mahasiswa.nama as nama_mahasiswa',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.tgl_ajuan',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai'
            )
            ->where('bimbingan_dosen.status', 'disetujui')
            ->whereIn('bimbingan_dosen.kd_pembimbing', $pembimbing);

        if ($bulan) {
            $query->whereMonth('sesi_bimbingan.tgl_ajuan', $bulan);
        }
        if ($tahun) {
            $query->whereYear('sesi_bimbingan.tgl_ajuan', $tahun);
        }

        $jadwal = $query->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')->get();

        $pdf = Pdf::loadView('pembimbing.jadwal_pdf', compact('jadwal', 'bulan', 'tahun'))
                ->setPaper('A4', 'landscape');

        return $pdf->stream('jadwal-bimbingan.pdf');
    }

    public function selesai($kd_bimbingan)
    {
        DB::table('bimbingan_dosen')
            ->where('kd_bimbingan', $kd_bimbingan)
            ->update(['status' => 'selesai']);

        return redirect()->back()->with('success', 'Bimbingan telah selesai');
    }

    public function riwayatAjuan()
    {
        $nip = auth()->guard('dosen')->user()->nip; // Sesuaikan dengan guard dosen

        $mahasiswa = DB::table('pembimbing_mahasiswa')
            ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('mahasiswa', 'pembimbing_mahasiswa.npm', '=', 'mahasiswa.npm')
            ->leftJoin('sesi_bimbingan', 'mahasiswa.npm', '=', 'sesi_bimbingan.npm')
            ->select('mahasiswa.npm', 'mahasiswa.nama')
            ->where('pembimbing.nip', $nip)
            ->groupBy('mahasiswa.npm', 'mahasiswa.nama')
            ->get();
        
        $bimbingan = DB::table('bimbingan_dosen')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->select(
                'sesi_bimbingan.topik',
                'mahasiswa.nama as nama_mahasiswa',
                'sesi_bimbingan.tgl_ajuan',
                'bimbingan_dosen.status',
                'bimbingan_dosen.komentar_penolakan'
            )
            ->where('pembimbing.nip', $nip)
            ->whereNotIn('bimbingan_dosen.status', ['Menunggu', 'Selesai'])
            ->orderByDesc('sesi_bimbingan.tgl_ajuan')
            ->get();


        return view('pembimbing.riwayatBimbingan', compact('mahasiswa','bimbingan'));
    }

    public function filterRiwayatAjuan(Request $request)
    {
        $nip = auth()->guard('dosen')->user()->nip;

        $query = DB::table('bimbingan_dosen')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->select(
                'sesi_bimbingan.topik',
                'mahasiswa.nama as nama_mahasiswa',
                'sesi_bimbingan.tgl_ajuan',
                'bimbingan_dosen.status',
                'bimbingan_dosen.komentar_penolakan'
            )
            ->where('pembimbing.nip', $nip)
            ->whereNotIn('bimbingan_dosen.status', ['Menunggu', 'Selesai']);

        if ($request->nama) {
            $query->where('mahasiswa.nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->status) {
            $query->where('bimbingan_dosen.status', $request->status);
        }

        $bimbingan = $query->orderByDesc('sesi_bimbingan.tgl_ajuan')->get();

        return response()->json($bimbingan);
    }

    public function cetakRiwayatAjuan(Request $request)
    {
        $nip = auth()->guard('dosen')->user()->nip;

        $query = DB::table('bimbingan_dosen')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('sesi_bimbingan', 'bimbingan_dosen.kd_sesi', '=', 'sesi_bimbingan.kd_sesi')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->select(
                'sesi_bimbingan.topik',
                'mahasiswa.nama as nama_mahasiswa',
                'sesi_bimbingan.tgl_ajuan',
                'bimbingan_dosen.status',
                'bimbingan_dosen.komentar_penolakan'
            )
            ->where('pembimbing.nip', $nip)
            ->whereNotIn('bimbingan_dosen.status', ['Menunggu', 'Selesai']);

        if ($request->nama) {
            $query->where('mahasiswa.nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->status) {
            $query->where('bimbingan_dosen.status', $request->status);
        }

        $bimbingan = $query->orderByDesc('sesi_bimbingan.tgl_ajuan')->get();

        $pdf = Pdf::loadView('pembimbing.riwayat_pdf', compact('bimbingan'))->setPaper('A4', 'landscape');
        return $pdf->stream('riwayat_ajuan.pdf');
    }
}
