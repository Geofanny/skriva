<?php

namespace App\Http\Controllers\pembimbing;

use Carbon\Carbon;
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
        $nip = Auth::guard('pembimbing')->user()->nip;
    
        // Data Card
        $bimbinganHariIni = DB::table('sesi_bimbingan')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->whereDate('sesi_bimbingan.tgl_ajuan', Carbon::today())
            ->where('bimbingan_dosen.status', 'Disetujui')
            ->whereIn('bimbingan_dosen.kd_pembimbing', function ($q) use ($nip) {
                $q->select('kd_pembimbing')
                  ->from('pembimbing')
                  ->where('nip', $nip);
            })
            ->count();
    
        $belumDisetujui = DB::table('bimbingan_dosen')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->where('pembimbing.nip', $nip)
            ->where('bimbingan_dosen.status', 'menunggu')
            ->count();
    
        $totalDibimbing = DB::table('pembimbing')
            ->join('pembimbing_mahasiswa', 'pembimbing.kd_pembimbing', '=', 'pembimbing_mahasiswa.kd_pembimbing')
            ->where('pembimbing.nip', $nip)
            ->distinct('pembimbing_mahasiswa.npm')
            ->count('pembimbing_mahasiswa.npm');
    
        // Ambil data kalender bulan ini
        $bulan = now()->month;
        $tahun = now()->year;
    
        $bimbinganPerTanggal = DB::table('sesi_bimbingan')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->whereMonth('sesi_bimbingan.tgl_ajuan', $bulan)
            ->whereYear('sesi_bimbingan.tgl_ajuan', $tahun)
            ->where('pembimbing.nip', $nip)
            ->where('bimbingan_dosen.status', 'disetujui')
            ->selectRaw('DAY(sesi_bimbingan.tgl_ajuan) as tanggal, COUNT(*) as jumlah')
            ->groupByRaw('DAY(sesi_bimbingan.tgl_ajuan)')
            ->pluck('jumlah', 'tanggal')
            ->toArray();

        // Semua Pengajuan
        $semuaPengajuan = DB::table('sesi_bimbingan')
        ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
        ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
        ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
        ->where('pembimbing.nip', $nip)
        ->selectRaw('mahasiswa.nama, COUNT(*) as total')
        ->groupBy('mahasiswa.nama')
        ->pluck('total', 'mahasiswa.nama')
        ->toArray();

        // Pengajuan Disetujui
        $disetujuiPengajuan = DB::table('sesi_bimbingan')
        ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
        ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
        ->join('mahasiswa', 'sesi_bimbingan.npm', '=', 'mahasiswa.npm')
        ->where('pembimbing.nip', $nip)
        ->where('bimbingan_dosen.status', 'disetujui')
        ->selectRaw('mahasiswa.nama, COUNT(*) as total')
        ->groupBy('mahasiswa.nama')
        ->pluck('total', 'mahasiswa.nama')
        ->toArray();

        // Gabungkan semua label
        $labels = array_unique(array_merge(array_keys($semuaPengajuan), array_keys($disetujuiPengajuan)));

        $chartLabels = [];
        $chartSemua = [];
        $chartDisetujui = [];

        foreach ($labels as $nama) {
        $chartLabels[] = $nama;
        $chartSemua[] = $semuaPengajuan[$nama] ?? 0;
        $chartDisetujui[] = $disetujuiPengajuan[$nama] ?? 0;
        }

        
    
        return view('pembimbing.index', compact(
            'bimbinganHariIni', 
            'belumDisetujui', 
            'totalDibimbing', 
            'bimbinganPerTanggal',
            'chartLabels', 'chartSemua', 'chartDisetujui'
        ));
    }
    
    public function getKalender(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $nip = Auth::guard('pembimbing')->user()->nip;

        $data = DB::table('sesi_bimbingan')
            ->join('bimbingan_dosen', 'sesi_bimbingan.kd_sesi', '=', 'bimbingan_dosen.kd_sesi')
            ->join('pembimbing', 'bimbingan_dosen.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->whereMonth('sesi_bimbingan.tgl_ajuan', $bulan)
            ->whereYear('sesi_bimbingan.tgl_ajuan', $tahun)
            ->where('pembimbing.nip', $nip)
            ->where('bimbingan_dosen.status', 'disetujui')
            ->selectRaw('DAY(sesi_bimbingan.tgl_ajuan) as tanggal, COUNT(*) as jumlah')
            ->groupByRaw('DAY(sesi_bimbingan.tgl_ajuan)')
            ->pluck('jumlah', 'tanggal')
            ->toArray();

        return response()->json($data);
    }

    public function profil()
    {
        $pembimbing = auth()->guard('pembimbing')->user();

        // Ambil data dosen lengkap (termasuk nama, prodi, foto, dll)
        $dosen = DB::table('pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->join('prodi', 'dosen.kd_prodi', '=', 'prodi.kd_prodi')
            ->select('dosen.*', 'prodi.nama_prodi')
            ->where('pembimbing.nip', $pembimbing->nip)
            ->first();
            
        return view('pembimbing.profil',compact('dosen'));
    }

    public function updateProfilPembimbing(Request $request)
    {
        // $request->validate([
        //     'nama' => 'required|string|max:50',
        //     'password_baru' => 'nullable|string|min:6|confirmed',
        //     'cropped_foto' => 'nullable|string',
        // ]);

        // dd($request->all());
    
        // Ambil user yang sedang login di guard koordinator
        $pembimbing = auth()->guard('pembimbing')->user();
        $dosen = Dosen::where('nip', $pembimbing->nip)->first();
    
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
            return redirect('/mentor-access/profil')->with('password_changed', true);
        }               
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
