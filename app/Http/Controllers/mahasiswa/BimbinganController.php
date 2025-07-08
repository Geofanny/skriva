<?php

namespace App\Http\Controllers\mahasiswa;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function bimbingan()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        $dataBimbingan = DB::table('sesi_bimbingan')
            ->leftJoin('file_bimbingan', 'sesi_bimbingan.kd_sesi', '=', 'file_bimbingan.kd_sesi')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('sesi_bimbingan.npm', $mahasiswa->npm)
            ->where('bimbingan_dosen.status', '!=', 'Selesai')
            ->select(
                'sesi_bimbingan.kd_sesi',
                'sesi_bimbingan.topik',
                'sesi_bimbingan.tgl_ajuan',
                'sesi_bimbingan.waktu_mulai',
                'sesi_bimbingan.waktu_selesai',
                'dosen.nama as nama_pembimbing',
                'bimbingan_dosen.status',
                'bimbingan_dosen.komentar_penolakan',
                'file_bimbingan.nama_file as file'
            )
            ->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')
            ->get();

            // Ambil daftar pembimbing mahasiswa yang login
            $pembimbingList = DB::table('pembimbing_mahasiswa')
            ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('pembimbing_mahasiswa.npm', $mahasiswa->npm)
            ->select('pembimbing.kd_pembimbing', 'dosen.nama')
            ->get();

        return view('mahasiswa.bimbingan', compact('dataBimbingan','pembimbingList'));
    }

    public function ajuanBimbingan(Request $request)
    {
        
        $npm = Auth::guard('mahasiswa')->user()->npm;
    
        // 🔢 Generate kode sesi otomatis
        $lastKode = DB::table('sesi_bimbingan')->orderBy('kd_sesi', 'desc')->value('kd_sesi');
        $newKodeSesi = 'SSI' . str_pad((int)Str::of($lastKode)->after('SSI')->__toString() + 1, 3, '0', STR_PAD_LEFT);
    
        // 💾 Simpan ke sesi_bimbingan
        DB::table('sesi_bimbingan')->insert([
            'kd_sesi' => $newKodeSesi,
            'npm' => $npm,
            'topik' => $request->topik,
            'tgl_ajuan' => $request->tanggal,
            'waktu_mulai' => $request->jam_mulai,
            'waktu_selesai' => $request->jam_selesai,
        ]);
    
        // 🔢 Generate kode bimbingan otomatis
        $lastKodeBimbingan = DB::table('bimbingan_dosen')->orderBy('kd_bimbingan', 'desc')->value('kd_bimbingan');
        $newKodeBimbingan = 'BIM' . str_pad((int)Str::of($lastKodeBimbingan)->after('BIM')->__toString() + 1, 3, '0', STR_PAD_LEFT);
    
        // 💾 Simpan ke bimbingan_dosen
        DB::table('bimbingan_dosen')->insert([
            'kd_bimbingan' => $newKodeBimbingan,
            'kd_pembimbing' => $request->pembimbing,
            'komentar_penolakan' => '-',
            'status' => 'Menunggu', // default status awal
            'kd_sesi' => $newKodeSesi,
        ]);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $filename = 'bimbingan_' . time() . '_' . Str::random(8) . '.' . $ext;
            $file->storeAs('/bimbingan', $filename); // storage/app/bimbingan

            // Generate kd_file
            $lastFile = DB::table('file_bimbingan')->orderBy('kd_file', 'desc')->first();
            $nextFile = $lastFile ? (int) substr($lastFile->kd_file, 3) + 1 : 1;
            $kd_file = 'FLE' . str_pad($nextFile, 3, '0', STR_PAD_LEFT);

            DB::table('file_bimbingan')->insert([
                'kd_file' => $kd_file,
                'nama_file' => $filename,
                'tgl_upload' => now(),
                'kd_sesi' => $newKodeSesi
            ]);
        }
    
        return redirect('/dashboard/bimbingan')->with('success', 'Pengajuan bimbingan berhasil dikirim.');
    }
    
    public function destroyBimbingan($kd_sesi)
    {
        DB::table('bimbingan_dosen')->where('kd_sesi', $kd_sesi)->delete();
        DB::table('sesi_bimbingan')->where('kd_sesi', $kd_sesi)->delete();
        return redirect('/dashboard/bimbingan')->with('success', 'Sesi bimbingan berhasil dihapus.');
    }

    public function skripsi()
    {
        $npm = Auth::guard('mahasiswa')->user()->npm;
        $skripsi = DB::table('skripsi')->where('npm',$npm)->first();

        $pembimbing1 = DB::table('pembimbing_mahasiswa')
         ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
         ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
         ->where('pembimbing_mahasiswa.npm', $npm)
         ->where('posisi','Pembimbing 1')
         ->select('pembimbing.kd_pembimbing', 'dosen.nama','dosen.nip')
         ->first();

        $pembimbing2 = DB::table('pembimbing_mahasiswa')
        ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
        ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
        ->where('pembimbing_mahasiswa.npm', $npm)
        ->where('posisi','Pembimbing 2')
        ->select('pembimbing.kd_pembimbing', 'dosen.nama','dosen.nip')
        ->first();

        // dd($pembimbing1);
        // die;
        return view('mahasiswa.skripsi',compact('skripsi', 'pembimbing1','pembimbing2'));
    }

    public function ajuanSkripsi(Request $request)
    {
        $npm = Auth::guard('mahasiswa')->user()->npm;
        $last3 = substr($npm, -3);
    
        // Ambil skripsi terakhir dari mahasiswa dengan 3 digit terakhir yang sama
        $lastSkripsi = DB::table('skripsi')
            ->whereRaw('RIGHT(kd_skripsi, 5) LIKE ?', ["{$last3}%"])
            ->orderBy('kd_skripsi', 'desc')
            ->first();
    
        if ($lastSkripsi) {
            // Ambil nomor urut terakhir, misal: KS12305 → ambil 05 → +1 = 06
            $lastNumber = (int) substr($lastSkripsi->kd_skripsi, -2);
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada sama sekali
            $newNumber = '01';
        }
    
        $kd_skripsi = 'KS' . $last3 . $newNumber;
    
        // Cek apakah sudah punya skripsi
        $existing = DB::table('skripsi')->where('npm', $npm)->first();
    
        if ($existing) {
            // Update
            DB::table('skripsi')->where('npm', $npm)->update([
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'tgl_upload' => now(),
            ]);
        } else {
            // Insert
            DB::table('skripsi')->insert([
                'kd_skripsi' => $kd_skripsi,
                'npm' => $npm,
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'tgl_upload' => now(),
            ]);
        }
    
        return redirect('/dashboard/skripsi')->with('success', 'Skripsi berhasil disimpan.');
    }

    public function pembimbing()
    {
        $npm = Auth::guard('mahasiswa')->user()->npm;
        $pembimbing1 = DB::table('pembimbing_mahasiswa')
         ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
         ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
         ->join('prodi', 'dosen.kd_prodi', '=', 'prodi.kd_prodi')
         ->where('pembimbing_mahasiswa.npm', $npm)
         ->where('posisi','Pembimbing 1')
         ->select('pembimbing.kd_pembimbing', 'dosen.nama','dosen.foto','dosen.nip','prodi.nama_prodi')
         ->first();

        $pembimbing2 = DB::table('pembimbing_mahasiswa')
        ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
        ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
        ->join('prodi', 'dosen.kd_prodi', '=', 'prodi.kd_prodi')
        ->where('pembimbing_mahasiswa.npm', $npm)
        ->where('posisi','Pembimbing 2')
        ->select('pembimbing.kd_pembimbing', 'dosen.nama','dosen.foto','dosen.nip','prodi.nama_prodi')
        ->first();

        return view('mahasiswa.pembimbing',compact('pembimbing1','pembimbing2'));
    }

    public function riwayatAjuan()
    {
        $npm = auth('mahasiswa')->user()->npm;

        $riwayatQuery = DB::table('sesi_bimbingan')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('sesi_bimbingan.npm', $npm)
            ->where('bimbingan_dosen.status', '!=', 'menunggu')
            ->select(
                'sesi_bimbingan.topik',
                'sesi_bimbingan.tgl_ajuan',
                'dosen.nama as nama_pembimbing',
                'bimbingan_dosen.status',
                'bimbingan_dosen.komentar_penolakan'
            );
        
        if (request('pembimbing')) {
            $riwayatQuery->where('dosen.nama', request('pembimbing'));
        }
        
        if (request('status')) {
            $riwayatQuery->where('bimbingan_dosen.status', request('status'));
        }
        
        $riwayat = $riwayatQuery->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')->get();
        
        
        // Ambil daftar pembimbing mahasiswa ini
        $daftarPembimbing = DB::table('pembimbing_mahasiswa')
        ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
        ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
        ->where('pembimbing_mahasiswa.npm', $npm)
        ->select('dosen.nama')
        ->distinct()
        ->get();
    
        return view('mahasiswa.RiwayatBimbingan', compact('riwayat','daftarPembimbing'));
    }

    public function cetakPDF()
    {
        $npm = auth('mahasiswa')->user()->npm;
        
        $mahasiswa = DB::table('mahasiswa')
        ->join('prodi', 'mahasiswa.kd_prodi', '=', 'prodi.kd_prodi')
        ->select(
            'mahasiswa.*',
            'prodi.nama_prodi',
            'prodi.fakultas',
            'prodi.nama_prodi'
        )
        ->where('mahasiswa.npm', auth('mahasiswa')->user()->npm)
        ->first();
    

        $riwayatQuery = DB::table('sesi_bimbingan')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->where('sesi_bimbingan.npm', $npm)
            ->where('bimbingan_dosen.status', '!=', 'menunggu')
            ->select(
                'sesi_bimbingan.topik',
                'sesi_bimbingan.tgl_ajuan',
                'dosen.nama as nama_pembimbing',
                'bimbingan_dosen.status',
                'bimbingan_dosen.komentar_penolakan'
            );

        if (request('pembimbing')) {
            $riwayatQuery->where('dosen.nama', request('pembimbing'));
        }

        if (request('status')) {
            $riwayatQuery->where('bimbingan_dosen.status', request('status'));
        }

        $riwayat = $riwayatQuery->orderBy('sesi_bimbingan.tgl_ajuan', 'desc')->get();

        $pdf = Pdf::loadView('mahasiswa.riwayat_pdf', compact('riwayat','mahasiswa'))->setPaper('A4', 'portrait') ->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream('riwayat-ajuan-bimbingan.pdf');
    }
}
