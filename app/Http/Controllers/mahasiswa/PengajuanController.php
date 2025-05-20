<?php

namespace App\Http\Controllers\mahasiswa;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PengajuanController extends Controller
{
    public function pengajuanJudul()
    {
        return view('mahasiswa.pengajuanJudul');
    }

    public function ajukan(Request $request)
    {
        $mahasiswa = DB::table('mahasiswa')->where('npm', '202333500646')->first();

        $prodi = strtolower(trim($mahasiswa->prodi));

        $dospem_1 = DB::table('detail_daftar')
            ->join('daftar_bimbingan', 'detail_daftar.kd_bimbingan', '=', 'daftar_bimbingan.kd_bimbingan')
            ->select('daftar_bimbingan.nip')
            ->where('npm', $mahasiswa->npm)
            ->first();



        $dospem_2 = DB::table('detail_daftar')
            ->join('daftar_bimbingan', 'detail_daftar.kd_bimbingan', '=', 'daftar_bimbingan.kd_bimbingan')
            ->select('daftar_bimbingan.nip')
            ->where('npm', $mahasiswa->npm)
            ->where('pembimbing','2')
            ->orderBy('daftar_bimbingan.nip', 'desc')
            ->first();

            // dd($dospem_2);
            // die;

        if (!$dospem_1 || !$dospem_2 || $dospem_1->nip === $dospem_2->nip) {
            return redirect('/pengajuanJudul')->with('error', 'Data dosen pembimbing tidak valid');
        }

        // Generate kode prodi
        $kodeProdi = $prodi === 'arsitektur'
            ? strtoupper(substr($prodi, 0, 3))
            : collect(explode(' ', $prodi))->map(fn($p) => strtoupper(substr($p, 0, 1)))->implode('');

        // 3 digit terakhir NPM
        $npmDigits = substr($mahasiswa->npm, -3);

        // Nomor urut pengajuan
        $prefix = 'KD' . $kodeProdi . $npmDigits;
        $last = DB::table('pengajuan_judul')
            ->where('kd_ajuan', 'like', $prefix . '%')
            ->orderByDesc('kd_ajuan')
            ->first();

        $lastNumber = $last ? (int) substr($last->kd_ajuan, -3) : 0;
        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Kode pengajuan akhir
        $kd_ajuan = $prefix . $nextNumber;

        $kd_judul = 'JDL' . $npmDigits . $nextNumber;

        // Simpan ke pengajuan_judul
        DB::table('pengajuan_judul')->insert([
            'kd_ajuan' => $kd_ajuan,
            'npm' => $mahasiswa->npm,
            'nip_dospem_1' => $dospem_1->nip,
            'nip_dospem_2' => $dospem_2->nip,
            'tgl_pengajuan' => Carbon::today()->format('Y-m-d'),
        ]);

        foreach ($request->judul as $index => $judul) {
            $kd_judul = 'JDL' . $npmDigits . $nextNumber . $index;
        
            DB::table('detail_judul')->insert([
                'kd_judul' => $kd_judul,
                'kd_ajuan' => $kd_ajuan,
                'judul' => $judul,
                'kategori' => $request->kategori,
                'status' => 'pending',
                'komentar_dospem1' => '-',
                'komentar_dospem2' => '-',
            ]);
        }
        

        return redirect('/pengajuanJudul')->with('success', 'Pengajuan judul berhasil diajukan.');
    }
}
