<?php

namespace App\Http\Controllers\mahasiswa;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {   
        $mahasiswa = Auth::guard('mahasiswa')->user();

         // Ambil daftar pembimbing mahasiswa yang login
         $pembimbing1 = DB::table('pembimbing_mahasiswa')
         ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
         ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
         ->where('pembimbing_mahasiswa.npm', $mahasiswa->npm)
         ->where('posisi','Pembimbing 1')
         ->select('pembimbing.kd_pembimbing', 'dosen.nama','dosen.nip')
         ->first();

         $pembimbing2 = DB::table('pembimbing_mahasiswa')
         ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
         ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
         ->where('pembimbing_mahasiswa.npm', $mahasiswa->npm)
         ->where('posisi','Pembimbing 2')
         ->select('pembimbing.kd_pembimbing', 'dosen.nama','dosen.nip')
         ->first();

         $totalDisetujui = DB::table('sesi_bimbingan')
         ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
         ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
         ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
         ->where('sesi_bimbingan.npm', $mahasiswa->npm)
         ->where('status','Disetujui')
         ->count();

        // Ambil jadwal bimbingan hari ini dan yang sudah disetujui
        $jadwalBimbingan = DB::table('sesi_bimbingan')
        ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
        ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
        ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
        ->whereDate('sesi_bimbingan.tgl_ajuan', today())
        ->where('sesi_bimbingan.npm', $mahasiswa->npm)
        ->where('bimbingan_dosen.status', 'Disetujui')
        ->select('sesi_bimbingan.waktu_mulai', 'sesi_bimbingan.waktu_selesai', 'sesi_bimbingan.topik', 'dosen.nama as nama_dosen')
        ->orderBy('sesi_bimbingan.waktu_mulai')
        ->get();

       // Hitung tanggal padat untuk pembimbing 1 dan 2
        $tanggalPadat = collect();

        if ($pembimbing1?->nip) {
            $padat1 = DB::table('sesi_bimbingan')
                ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
                ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
                ->where('pembimbing.nip', $pembimbing1->nip)
                ->where('bimbingan_dosen.status', 'Disetujui')
                ->selectRaw("DATE_FORMAT(sesi_bimbingan.tgl_ajuan, '%m-%d') as tanggal, COUNT(DISTINCT sesi_bimbingan.npm) as jumlah_mahasiswa")
                ->groupBy('tanggal')
                ->having('jumlah_mahasiswa', '>=', 5)
                ->get()
                ->map(fn($item) => ['tanggal' => $item->tanggal, 'posisi' => 'Pembimbing 1']);

            $tanggalPadat = $tanggalPadat->merge($padat1);
        }

        if ($pembimbing2?->nip) {
            $padat2 = DB::table('sesi_bimbingan')
                ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
                ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
                ->where('pembimbing.nip', $pembimbing2->nip)
                ->where('bimbingan_dosen.status', 'Disetujui')
                ->selectRaw("DATE_FORMAT(sesi_bimbingan.tgl_ajuan, '%m-%d') as tanggal, COUNT(DISTINCT sesi_bimbingan.npm) as jumlah_mahasiswa")
                ->groupBy('tanggal')
                ->having('jumlah_mahasiswa', '>=', 5)
                ->get()
                ->map(fn($item) => ['tanggal' => $item->tanggal, 'posisi' => 'Pembimbing 2']);

            $tanggalPadat = $tanggalPadat->merge($padat2);
        }

        $kalenderPadat = $tanggalPadat->values()->all();

        // dd($kalenderPadat);
        // die;

        return view('mahasiswa.index',compact('pembimbing1','pembimbing2','totalDisetujui','jadwalBimbingan','kalenderPadat'));
    }

    
    public function profil()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.profil', compact('mahasiswa'));
    }

    public function updateProfil(Request $request)
    {

        $mahasiswa = auth('mahasiswa')->user();

        // Update nama
        $mahasiswa->nama = $request->nama;

        // Update password jika ada
        if ($request->password_baru) {
            $mahasiswa->password = Hash::make($request->password_baru);
        }

        // Simpan foto hasil crop (base64)
        if ($request->cropped_foto) {
            // Hapus foto lama
            if ($mahasiswa->foto && Storage::exists('fotoProfil/' . $mahasiswa->foto)) {
                Storage::delete('fotoProfil/' . $mahasiswa->foto);
            }

            // Ubah base64 ke file (convert)
            $base64 = $request->cropped_foto;
            $image = str_replace('data:image/jpeg;base64,', '', $base64);
            $image = str_replace(' ', '+', $image);
            $fileContent = base64_decode($image);

            // Buat nama file
            $filename = 'profil_' . time() . '_' . Str::random(8) . '.jpg';

            // Simpan menggunakan storeAs (di folder storage/app/fotoProfil)
            Storage::put("fotoProfil/{$filename}", $fileContent);

            // Simpan nama file ke database
            $mahasiswa->foto = $filename;
        }

        $mahasiswa->save();

        return redirect('/dashboard/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
