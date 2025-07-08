<?php

namespace App\Http\Controllers\koordinasi;

use App\Models\Dosen;
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
        $nipKoor = auth('koordinator')->user()->nip;

        // Ambil kd_prodi dan fakultas dari dosen yang login
        $kd_prodi = DB::table('dosen')->where('nip', $nipKoor)->value('kd_prodi');
        $fakultas = DB::table('prodi')->where('kd_prodi', $kd_prodi)->value('fakultas');

        // Ambil semua prodi dalam fakultas tersebut
        $prodiList = DB::table('prodi')->where('fakultas', $fakultas)->pluck('kd_prodi');

        // Total mahasiswa bimbingan (unik)
        $totalMahasiswaBimbingan = DB::table('pembimbing_mahasiswa')
            ->join('mahasiswa', 'pembimbing_mahasiswa.npm', '=', 'mahasiswa.npm')
            ->whereIn('mahasiswa.kd_prodi', $prodiList)
            ->distinct('mahasiswa.npm')
            ->count('mahasiswa.npm');

        // Total pembimbing
        $totalPembimbing = DB::table('pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->whereIn('dosen.kd_prodi', $prodiList)
            ->distinct('pembimbing.nip')
            ->count('pembimbing.nip');

        // Data pengajuan bimbingan per bulan tahun berjalan
        $tahunIni = now()->year;
        $pengajuanPerBulan = DB::table('sesi_bimbingan')
            ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
            ->whereIn('mahasiswa.kd_prodi', $prodiList)
            ->whereYear('sesi_bimbingan.tgl_ajuan', $tahunIni)
            ->selectRaw("MONTH(tgl_ajuan) as bulan, COUNT(*) as total")
            ->groupByRaw("MONTH(tgl_ajuan)")
            ->orderBy('bulan')
            ->get();

        // Label bulan dan data
        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $labelsBulan = collect($namaBulan); // 12 bulan

        $dataBulan = collect(range(1, 12))->map(function ($bulan) use ($pengajuanPerBulan) {
            $found = $pengajuanPerBulan->firstWhere('bulan', $bulan);
            return $found ? $found->total : 0;
        });

        
        // Ambil semua prodi dalam fakultas koordinator login
        $prodiListFull = DB::table('prodi')
        ->where('fakultas', $fakultas)
        ->get();

        // Data pembimbing per prodi (Pie Chart)
        $pembimbingPerProdi = DB::table('prodi')
        ->leftJoin('dosen', 'prodi.kd_prodi', '=', 'dosen.kd_prodi')
        ->leftJoin('pembimbing', 'dosen.nip', '=', 'pembimbing.nip')
        ->where('prodi.fakultas', $fakultas)
        ->select('prodi.nama_prodi', DB::raw('COUNT(DISTINCT pembimbing.kd_pembimbing) as total'))
        ->groupBy('prodi.nama_prodi')
        ->get();

        $labelProdi = $pembimbingPerProdi->pluck('nama_prodi');

        // dd($pembimbingPerProdi);
        // die;
        $dataProdi = $pembimbingPerProdi->pluck('total');

        return view('koordinasi.index', compact(
            'totalMahasiswaBimbingan',
            'totalPembimbing',
            'labelsBulan',
            'dataBulan',
            'labelProdi',
            'dataProdi'
        ));
    }

    public function profil()
    {
        $koordinator = auth()->guard('koordinator')->user();

        // Ambil data dosen lengkap (termasuk nama, prodi, foto, dll)
        $dosen = DB::table('koordinasi_ta')
            ->join('dosen', 'koordinasi_ta.nip', '=', 'dosen.nip')
            ->join('prodi', 'dosen.kd_prodi', '=', 'prodi.kd_prodi')
            ->select('dosen.*', 'prodi.nama_prodi')
            ->where('koordinasi_ta.nip', $koordinator->nip)
            ->first();

        return view('koordinasi.profil', compact('dosen'));
    }

    public function updateProfilKoordinasi(Request $request)
    {
        // $request->validate([
        //     'nama' => 'required|string|max:50',
        //     'password_baru' => 'nullable|string|min:6|confirmed',
        //     'cropped_foto' => 'nullable|string',
        // ]);

        // dd($request->all());
    
        // Ambil user yang sedang login di guard koordinator
        $koordinator = auth()->guard('koordinator')->user();
        $dosen = Dosen::where('nip', $koordinator->nip)->first();
    
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }
    
        // Update nama
        $dosen->nama = $request->nama;
    
        // Update password jika diisi
        $passwordDiubah = false;
        if ($request->password_baru) {
            $dosen->password = Hash::make($request->password_baru);
            $passwordDiubah = true;
        }
    
        // Update foto jika ada input base64
        if ($request->cropped_foto) {
            // Hapus foto lama jika ada
            if ($dosen->foto && Storage::exists('fotoProfil/' . $dosen->foto)) {
                Storage::delete('fotoProfil/' . $dosen->foto);
            }
    
            // Simpan foto baru dari base64
            $image = str_replace('data:image/jpeg;base64,', '', $request->cropped_foto);
            $image = str_replace(' ', '+', $image);
            $fileContent = base64_decode($image);
    
            $filename = 'profil_' . time() . '_' . Str::random(8) . '.jpg';
            Storage::put("fotoProfil/{$filename}", $fileContent);
    
            $dosen->foto = $filename;
        }
    
        $dosen->save();
    
        if ($passwordDiubah) {
            return redirect('/coord-panel/profil')->with('password_changed', true);
        }               
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
    

}
