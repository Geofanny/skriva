<?php

namespace App\Http\Controllers\koordinasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PembimbingController extends Controller
{
    public function index()
    {
        // Step 1: Ambil nip koordinator login
        $nipKoor = auth('koordinator')->user()->nip;
    
        // Step 2: Ambil kd_prodi dari dosen
        $kd_prodi_koor = DB::table('dosen')
            ->where('nip', $nipKoor)
            ->value('kd_prodi');
    
        // Step 3: Ambil fakultas berdasarkan prodi koordinator
        $fakultas = DB::table('prodi')
            ->where('kd_prodi', $kd_prodi_koor)
            ->value('fakultas');
    
        // Step 4: Ambil seluruh kd_prodi yang satu fakultas
        $kd_prodiList = DB::table('prodi')
            ->where('fakultas', $fakultas)
            ->pluck('kd_prodi');
    
        // Step 5: Ambil pembimbing berdasarkan kd_prodi dalam fakultas
        $daftarPembimbing = DB::table('pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->join('prodi', 'dosen.kd_prodi', '=', 'prodi.kd_prodi')
            ->whereIn('dosen.kd_prodi', $kd_prodiList)
            ->orderByRaw('CAST(RIGHT(kd_pembimbing, 2) AS UNSIGNED)')
            ->select('pembimbing.*', 'dosen.nama', 'dosen.kd_prodi','dosen.nip', 'prodi.nama_prodi')
            ->get();
    
        // Hitung jumlah mahasiswa tiap pembimbing
        $jumlahMahasiswa = [];
        foreach ($daftarPembimbing as $pembimbing) {
            $jumlahMahasiswa[$pembimbing->kd_pembimbing] = DB::table('pembimbing_mahasiswa')
                ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
                ->count();
        }
    
        // Daftar prodi hanya dari fakultas tersebut
        $daftarProdi = DB::table('prodi')
            ->where('fakultas', $fakultas)
            ->select('kd_prodi', 'nama_prodi')
            ->get();
    
        return view('koordinasi.pembimbing.pembimbing', compact('daftarPembimbing', 'jumlahMahasiswa', 'daftarProdi'));
    }
    

    // public function tambahPembimbing()
    // {
    //     // Ambil data prodi
    //     $daftarProdi = DB::table('prodi')
    //     ->select('kd_prodi', 'nama_prodi')
    //     ->get();

    //     // Ambil semua dosen
    //     $semuaDosen = DB::table('dosen')
    //         ->select('nip', 'nama', 'kd_prodi')
    //         ->get();

    //     // Ambil status pembimbing per dosen
    //     $pembimbingStatus = DB::table('pembimbing')
    //         ->select('nip', 'posisi')
    //         ->get()
    //         ->groupBy('nip')
    //         ->map(function ($item) {
    //             return $item->pluck('posisi')->toArray(); // contoh: ['pembimbing 1'], ['pembimbing 1', 'pembimbing 2']
    //         });

    //     // Filter dosen yang belum punya dua posisi sekaligus
    //     $daftarDosen = $semuaDosen->filter(function ($dosen) use ($pembimbingStatus) {
    //         $posisi = $pembimbingStatus[$dosen->nip] ?? [];
    //         return count($posisi) < 2; // jika sudah dua posisi, tidak ditampilkan
    //     })->map(function ($dosen) use ($pembimbingStatus) {
    //         $posisi = $pembimbingStatus[$dosen->nip] ?? [];
    //         $dosen->tersedia = [];

    //         if (!in_array('pembimbing 1', $posisi)) {
    //             $dosen->tersedia[] = 'pembimbing 1';
    //         }
    //         if (!in_array('pembimbing 2', $posisi)) {
    //             $dosen->tersedia[] = 'pembimbing 2';
    //         }

    //         return $dosen;
    //     })->values();


    //     return view('koordinasi.pembimbing.tambah', compact('daftarProdi', 'daftarDosen'));
    // }

    public function tambahPembimbing()
    {
         // Ambil semua prodi
        $daftarProdi = DB::table('prodi')->select('kd_prodi', 'nama_prodi')->get();

        // Ambil semua NIP dosen yang sudah jadi koordinator TA
        $nipKoordinator = DB::table('koordinasi_ta')->pluck('nip')->toArray();

        // Ambil dosen yang belum jadi koordinator TA saja
        $daftarDosen = DB::table('dosen')
            ->select('nip', 'nama', 'kd_prodi')
            ->whereNotIn('nip', $nipKoordinator)
            ->get();
            
        return view('koordinasi.pembimbing.tambah', compact('daftarProdi', 'daftarDosen'));
    }

    public function getMahasiswa($kd_pembimbing)
    {
        // Ambil info dosen dan prodi
        $dosen = DB::table('pembimbing')
            ->join('dosen', 'pembimbing.nip', '=', 'dosen.nip')
            ->join('prodi', 'dosen.kd_prodi', '=', 'prodi.kd_prodi')
            ->where('pembimbing.kd_pembimbing', $kd_pembimbing)
            ->select('dosen.nama as nama_dosen', 'prodi.nama_prodi')
            ->first();
    
        // Ambil mahasiswa
        $mahasiswa = DB::table('pembimbing_mahasiswa')
            ->join('mahasiswa', 'pembimbing_mahasiswa.npm', '=', 'mahasiswa.npm')
            ->where('pembimbing_mahasiswa.kd_pembimbing', $kd_pembimbing)
            ->select('mahasiswa.nama', 'mahasiswa.npm')
            ->get();
    
        return response()->json([
            'prodi' => $dosen->nama_prodi ?? '',
            'mahasiswa' => $mahasiswa
        ]);
    }

    // public function getMahasiswaByProdi($kd_prodi)
    // {
    //     // Ambil semua NPM yang sudah pernah didaftarkan sebagai mahasiswa pembimbing
    //     $npmTerdaftar = DB::table('pembimbing_mahasiswa')->pluck('npm');

    //     $mahasiswa = DB::table('mahasiswa')
    //     ->where('kd_prodi', $kd_prodi)
    //     ->whereNotIn('npm', function ($query) {
    //         $query->select('npm')
    //             ->from('pembimbing_mahasiswa')
    //             ->groupBy('npm')
    //             ->havingRaw('COUNT(*) >= 2'); // hanya kecualikan yang sudah punya 2 pembimbing
    //     })
    //     ->select('npm', 'nama')
    //     ->get();

    //     return response()->json($mahasiswa);
    // }

    public function getMahasiswaByProdi($kd_prodi, $nip)
    {
        // Ambil semua mahasiswa yang sudah dibimbing oleh NIP tersebut (baik posisi 1 maupun 2)
        $npmYangDibimbingOlehDosenIni = DB::table('pembimbing_mahasiswa')
            ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->where('pembimbing.nip', $nip)
            ->pluck('pembimbing_mahasiswa.npm');

        // Ambil mahasiswa yang belum punya 2 pembimbing DAN belum dibimbing oleh dosen ini
        // $mahasiswa = DB::table('mahasiswa')
        //     ->where('kd_prodi', $kd_prodi)
        //     ->whereNotIn('npm', function ($query) {
        //         $query->select('npm')
        //             ->from('pembimbing_mahasiswa')
        //             ->groupBy('npm')
        //             ->havingRaw('COUNT(*) >= 2');
        //     })
        //     ->whereNotIn('npm', $npmYangDibimbingOlehDosenIni)
        //     ->select('npm', 'nama')
        // ->get();

        // Mahasiswa yang sudah punya pembimbing posisi 1
        $pembimbing1 = DB::table('pembimbing_mahasiswa')
            ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->where('pembimbing.posisi', 'Pembimbing 1')
            ->pluck('pembimbing_mahasiswa.npm')
            ->toArray();

        // Mahasiswa yang sudah punya pembimbing posisi 2
        $pembimbing2 = DB::table('pembimbing_mahasiswa')
            ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
            ->where('pembimbing.posisi', 'Pembimbing 2')
            ->pluck('pembimbing_mahasiswa.npm')
            ->toArray();

        $mahasiswa = DB::table('mahasiswa')
            ->where('kd_prodi', $kd_prodi)
            ->select('npm', 'nama')
            ->get();

        $hasil = $mahasiswa->map(function ($mhs) use ($pembimbing1, $pembimbing2) {
            return [
                'npm' => $mhs->npm,
                'nama' => $mhs->nama,
                'punya_pembimbing1' => in_array($mhs->npm, $pembimbing1),
                'punya_pembimbing2' => in_array($mhs->npm, $pembimbing2),
            ];
        });


        return response()->json($hasil);
    }


    public function hapusMahasiswa(Request $request)
    {
        DB::table('pembimbing_mahasiswa')
            ->where('kd_pembimbing', $request->kd_pembimbing)
            ->where('npm', $request->npm)
            ->delete();

        return redirect('/coord-panel/daftarPembimbing')->with('success', 'Mahasiswa berhasil dihapus dari bimbinngan.');
    }


    // public function tambahMahasiswa(Request $request)
    // {
    //     $request->validate([
    //         'kd_pembimbing' => 'required|exists:pembimbing,kd_pembimbing',
    //         'jumlah' => 'required|integer|min:1|max:10',
    //         'npm' => 'required|array|min:1|max:10',
    //         'npm.*' => 'required|exists:mahasiswa,npm',
    //     ]);

    //     dd($request->all);
    //     die;

    //     $data = [];

    //     foreach ($request->npm as $npm) {
    //         $data[] = [
    //             'kd_pembimbing' => $request->kd_pembimbing,
    //             'npm' => $npm,
    //         ];
    //     }

    //     DB::table('pembimbing_mahasiswa')->insert($data);

    //     return redirect('/dashboard/daftarPembimbing')->with('success', 'Mahasiswa berhasil ditambahkan.');
    // }

    public function tambahMahasiswa(Request $request)
    {
        $request->validate([
            'kd_pembimbing' => 'required|exists:pembimbing,kd_pembimbing',
            'jumlah' => 'required|integer|min:1|max:10',
            'metode' => 'required|in:acak,manual',
        ]);

        $npmArray = [];

        if ($request->metode === 'acak') {
            $npmArray = $request->input('mahasiswa_acak');
        } elseif ($request->metode === 'manual') {
            $npmArray = $request->input('mahasiswa_manual');
        }

        // Validasi ulang npmArray
        if (!is_array($npmArray) || count($npmArray) == 0) {
            return back()->withErrors(['npm' => 'Tidak ada mahasiswa yang dipilih.']);
        }

        // Cek keberadaan mahasiswa di tabel mahasiswa
        foreach ($npmArray as $npm) {
            if (!DB::table('mahasiswa')->where('npm', $npm)->exists()) {
                return back()->withErrors(['npm' => "Mahasiswa dengan NPM $npm tidak ditemukan."]);
            }
        }

        // Siapkan data untuk insert
        $data = [];
        foreach ($npmArray as $npm) {
            $data[] = [
                'kd_pembimbing' => $request->kd_pembimbing,
                'npm' => $npm,
            ];
        }

        DB::table('pembimbing_mahasiswa')->insert($data);

        return redirect('/coord-panel/daftarPembimbing')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }



    public function getDosenByProdi($kd_prodi)
    {
       // Ambil NIP dosen yang sudah jadi koordinator
        $nipKoordinator = DB::table('koordinasi_ta')->pluck('nip')->toArray();

        // Ambil semua dosen sesuai prodi
        $dosen = DB::table('dosen')
            ->where('kd_prodi', $kd_prodi)
            ->whereNotIn('nip', $nipKoordinator)
            ->get();

        // Ambil posisi yang sudah diambil dari tabel pembimbing
        $pembimbing = DB::table('pembimbing')
            ->select('nip', 'posisi')
            ->get()
            ->groupBy('nip');

        // Filter dosen yang belum memiliki dua posisi
        $filtered = $dosen->filter(function ($dosen) use ($pembimbing) {
            $posisi = $pembimbing[$dosen->nip] ?? collect();
            return $posisi->count() < 2;
        })->map(function ($dosen) use ($pembimbing) {
            $posisi = $pembimbing[$dosen->nip] ?? collect();
            $dosen->posisi_terambil = $posisi->pluck('posisi')->values(); // misalnya ['pembimbing 1']
            return $dosen;
        })->values();

        return response()->json($filtered);
    }

    public function pembimbingBaru(Request $request)
    {
        
        $nip = $request->nip;
        $posisi = $request->posisi;
    
        // Ambil 6 digit terakhir dari NIP
        $lastSixDigits = substr($nip, -6);
        $prefix = 'PB' . $lastSixDigits;
    
        // Hitung total pembimbing untuk menentukan urutan
        $totalPembimbing = DB::table('pembimbing')->count();
    
        // Nomor urut berikutnya (total + 1)
        $newUrut = str_pad($totalPembimbing + 1, 2, '0', STR_PAD_LEFT);
    
        // Buat kode pembimbing
        $kd_pembimbing = $prefix . $newUrut;
    
        // Cegah duplikasi posisi pembimbing untuk dosen
        $cekDuplikat = DB::table('pembimbing')
            ->where('nip', $nip)
            ->where('posisi', $posisi)
            ->exists();
    
        if ($cekDuplikat) {
            return redirect()->back()->with('error', 'Dosen ini sudah menjadi ' . $posisi);
        }
    
        // Simpan data
        DB::table('pembimbing')->insert([
            'kd_pembimbing' => $kd_pembimbing,
            'nip' => $nip,
            'posisi' => $posisi,
        ]);

        return redirect('/coord-panel/daftarPembimbing')->with('success', 'Pembimbing baru berhasil ditambahkan.');
    }

    public function editPembimbing(Request $request,$kd_koordinasi)
    {
        // Ambil data koordinasi yang akan diedit
        $koordinasi = DB::table('koordinasi_ta')->where('kd_koordinasi', $kd_koordinasi)->first();
        
        // Ambil daftar prodi dan dosen
        $daftarProdi = DB::table('prodi')->get();
        $daftarDosen = DB::table('dosen')->get();

        return view('admin.koordinasiTa.edit', compact('koordinasi','daftarProdi', 'daftarDosen'));
    }

    public function update(Request $request, $nip)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kd_prodi' => 'required',
        ]);

        $data = [
            'nama' => $request->nama,
            'kd_prodi' => $request->kd_prodi,
        ];

        // Jika user mengisi password, hash dan simpan
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('dosen')->where('nip', $nip)->update($data);

        return redirect('/coord-panel/daftarDosen')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($kd_pembimbing)
    {
        DB::table('pembimbing')->where('kd_pembimbing', $kd_pembimbing)->delete();
        return redirect('/coord-panel/daftarPembimbing')->with('success', 'Pembimbing berhasil dihapus.');
    }
}
