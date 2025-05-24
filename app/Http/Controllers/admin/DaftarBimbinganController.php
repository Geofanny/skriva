<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DaftarBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $pembimbing = DB::table('daftar_bimbingan')
        ->join('dosen', 'daftar_bimbingan.nip', '=', 'dosen.nip')
        ->leftJoin('detail_daftar', 'daftar_bimbingan.kd_bimbingan', '=', 'detail_daftar.kd_bimbingan')
        ->select(
            'daftar_bimbingan.kd_bimbingan',
            'daftar_bimbingan.pembimbing',
            'daftar_bimbingan.slug',
            'dosen.prodi',
            'dosen.nama as nama_dosen',
            DB::raw('COUNT(detail_daftar.npm) as jumlah_mahasiswa')
        )
        ->groupBy('daftar_bimbingan.kd_bimbingan', 'dosen.nama')
        ->get();
    
        // Ambil seluruh mahasiswa per pembimbing
    $mahasiswa = DB::table('detail_daftar')
    ->join('mahasiswa', 'detail_daftar.npm', '=', 'mahasiswa.npm')
    ->select('detail_daftar.kd_bimbingan', 'mahasiswa.nama', 'mahasiswa.npm','mahasiswa.prodi')
    ->get()
    ->groupBy('kd_bimbingan');

    return view('admin.pembimbing.index', [
        'pembimbing' => $pembimbing,
        'mahasiswa' => $mahasiswa
    ]);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $dosenPembimbing = DB::table('dosen')->get();
        $dosenPembimbing = DB::table('dosen')->select('nip', 'nama', 'prodi')->get();
        
        foreach ($dosenPembimbing as $dosen) {
            $kategori_terpakai = DB::table('daftar_bimbingan')
                ->where('nip', $dosen->nip)
                ->pluck('pembimbing')
                ->toArray();
    
            $kategori_tersedia = collect([1, 2])->diff($kategori_terpakai)->values()->all();
    
            $dosen->kategori_tersedia = $kategori_tersedia;
        }

        return view('admin.pembimbing.tambahPembimbing',[
            'dosenPembimbing' => $dosenPembimbing,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Ambil data mahasiswa berdasarkan NPM
        $dosen = DB::table('dosen')->where('nip', $request->nip)->first();

        if (!$dosen) {
            return back()->with('error', 'Mahasiswa tidak ditemukan');
        }

        // Ambil nama prodi dari dosen
        $prodi = strtolower(trim($dosen->prodi));

        // Generate kode prodi dinamis
        if ($prodi === 'arsitektur') {
            $kodeProdi = strtoupper(substr($prodi, 0, 3)); // ARS
        } else {
            $parts = explode(' ', $prodi);
            $kodeProdi = '';
            foreach ($parts as $part) {
                if (!empty($part)) {
                    $kodeProdi .= strtoupper(substr($part, 0, 1));
                }
            }
        }

        // Cek kode terakhir dari tabel pembimbing
        $last = DB::table('daftar_bimbingan')
            ->where('kd_bimbingan', 'like', 'BIM' . $kodeProdi . '%')
            ->orderByDesc('kd_bimbingan')
            ->first();

        $lastNumber = 0;
        if ($last) {
            $lastNumber = (int) substr($last->kd_bimbingan, -4);
        }

        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $kd_bimbingan = 'BIM' . $kodeProdi . $nextNumber;
        $slug = 'S' . $kodeProdi . $nextNumber;
        $tgl_pembuatan = Carbon::today()->format('Y-m-d');

        // Simpan ke DB
        DB::table('daftar_bimbingan')->insert([
            'kd_bimbingan' => $kd_bimbingan,
            'nip' => $request->nip,
            'slug' => $slug,
            'pembimbing' => $request->pembimbing,
            'tgl_pembuatan' => $tgl_pembuatan,
        ]);

        return redirect()->route('pembimbing.index')->with('success', 'Pembimbing baru berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kd_bimbingan)
    {
        DB::table('daftar_bimbingan')->where('kd_bimbingan', $kd_bimbingan)->delete();
    
        return redirect()->route('pembimbing.index')->with('success', 'Data pembimbing berhasil dihapus.');
    }

    public function mahasiswa($slug)
    {
        $pembimbing = DB::table('daftar_bimbingan')
            ->join('dosen', 'daftar_bimbingan.nip', '=', 'dosen.nip')
            ->where('daftar_bimbingan.slug', $slug)
            ->select(
                'dosen.nama as nama_pembimbing',
                'daftar_bimbingan.pembimbing as kategori',
                'daftar_bimbingan.kd_bimbingan as kode',
                'dosen.prodi as prodi'
            )
            ->first();

        if (!$pembimbing) {
            abort(404, 'Data pembimbing tidak ditemukan.');
        }

        // $mahasiswaSudahDiambil = DB::table('detail_daftar')
        // ->join('daftar_bimbingan', 'detail_daftar.kd_bimbingan', '=', 'daftar_bimbingan.kd_bimbingan')
        // ->where('daftar_bimbingan.pembimbing', $pembimbing->kategori) // misalnya '1' atau '2'
        // ->pluck('detail_daftar.npm');

        $mahasiswaSudahDiambil = DB::table('detail_daftar')
        ->join('daftar_bimbingan', 'detail_daftar.kd_bimbingan', '=', 'daftar_bimbingan.kd_bimbingan')
        ->join('dosen', 'daftar_bimbingan.nip', '=', 'dosen.nip')
        ->where('daftar_bimbingan.pembimbing', $pembimbing->kategori)
        ->whereRaw('LOWER(dosen.prodi) = ?', [strtolower($pembimbing->prodi)])
        ->pluck('detail_daftar.npm');


        // Ambil mahasiswa dari prodi yang sama dan belum dibimbing
        $mahasiswa = DB::table('mahasiswa')
            ->whereRaw('LOWER(prodi) = ?', [strtolower($pembimbing->prodi)])
            ->whereNotIn('npm', $mahasiswaSudahDiambil)
            ->select('npm', 'nama', 'prodi')
            ->get();

        $jumlahSudahDibimbing = $mahasiswaSudahDiambil->count();
        $sisaKuota = 6 - $jumlahSudahDibimbing;

        return view('admin.pembimbing.tambahMahasiswa', [
            'mahasiswa' => $mahasiswa,
            'slug' => $slug,
            'prodi' => $pembimbing->prodi,
            'nama_pembimbing' => $pembimbing->nama_pembimbing,
            'kategori' => 'Pembimbing ' . $pembimbing->kategori,
            'kode' => $pembimbing->kode,
            'sisaKuota' => $sisaKuota
        ]);
    }

    public function daftarBimbingan(Request $request, $kode)
    {
        $request->validate([
            'mahasiswa' => 'required|array|min:1|max:6',
            'mahasiswa.*' => 'exists:mahasiswa,npm',
        ]);

        $mahasiswaList = $request->mahasiswa;

        foreach ($mahasiswaList as $npm) {
            $exists = DB::table('detail_daftar')
                ->where('kd_bimbingan', $kode)
                ->where('npm', $npm)
                ->exists();
        
            if (!$exists) {
                DB::table('detail_daftar')->insert([
                    'kd_bimbingan' => $kode,
                    'npm' => $npm,
                ]);
            }
        }
        

        return redirect('/pembimbing')->with('success', 'Mahasiswa berhasil ditambahkan ke daftar bimbingan.');
    }

    public function editDaftar($slug)
    {
        return view('admin.pembimbing.editMahasiswa');
    }


}
