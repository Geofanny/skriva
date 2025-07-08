<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KoordinasiTaController extends Controller
{
    public function index()
    {
        $koordinasiTa = DB::table('koordinasi_ta')
        ->join('prodi','koordinasi_ta.kd_prodi','=','prodi.kd_prodi')
        ->join('dosen','koordinasi_ta.nip','=','dosen.nip')
        ->get();

        // Ambil data prodi
        $daftarProdi = DB::table('prodi')
            ->select('kd_prodi', 'nama_prodi')
            ->get();

        // Ambil semua nip dosen yang sudah jadi pembimbing
        $nipPembimbing = DB::table('pembimbing')->pluck('nip');

        // Ambil semua nip dosen yang sudah jadi koordinasi TA
        $nipKoordinasi = DB::table('koordinasi_ta')->pluck('nip');

        // Ambil data dosen yang belum jadi pembimbing dan belum jadi koordinasi TA
        $daftarDosen = DB::table('dosen')
            ->whereNotIn('nip', $nipPembimbing)
            ->whereNotIn('nip', $nipKoordinasi)
            ->select('nip', 'nama', 'kd_prodi')
            ->get();

        return view('admin.koordinasiTa.koordinasi',compact('koordinasiTa','daftarProdi', 'daftarDosen'));
    }

    public function tambahKoordinasi()
    {
        // Ambil data prodi
        $daftarProdi = DB::table('prodi')
            ->select('kd_prodi', 'nama_prodi')
            ->get();

        // Ambil semua nip dosen yang sudah jadi pembimbing
        $nipPembimbing = DB::table('pembimbing')->pluck('nip');

        // Ambil semua nip dosen yang sudah jadi koordinasi TA
        $nipKoordinasi = DB::table('koordinasi_ta')->pluck('nip');

        // Ambil data dosen yang belum jadi pembimbing dan belum jadi koordinasi TA
        $daftarDosen = DB::table('dosen')
            ->whereNotIn('nip', $nipPembimbing)
            ->whereNotIn('nip', $nipKoordinasi)
            ->select('nip', 'nama', 'kd_prodi')
            ->get();

        return view('admin.koordinasiTa.tambah', compact('daftarProdi', 'daftarDosen'));
    }


    public function koordinasiBaru(Request $request)
    {
        // Ambil 6 digit terakhir dari NIP
        $nip = $request->nip;
        $lastSixDigits = substr($nip, -6); // Ambil 6 digit terakhir

        // Buat kode kd_koordinasi
        $kd_koordinasi = 'KR' . $lastSixDigits;

        // dd($kd_koordinasi);
        // die;

        // Cek apakah kode sudah ada
        $exists = DB::table('koordinasi_ta')
            ->where('kd_koordinasi', $kd_koordinasi)
            ->exists();

        if ($exists) {
            // Jika sudah ada, bisa tangani sesuai kebutuhan
            return back()->with('error', 'Kode koordinasi sudah ada.');
        }

        // Simpan data ke database
        DB::table('koordinasi_ta')->insert([
            'kd_koordinasi' => $kd_koordinasi,
            'kd_prodi' => $request->kd_prodi,
            'nip' => $request->nip,
        ]);

        return redirect('/sys-admin/daftarKoordinasi')->with('success', 'Koordinasi baru berhasil ditambahkan.');
    }

    public function editKoordinasi(Request $request,$kd_koordinasi)
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

        return redirect('/sys-admin/daftarKoordinasi')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($kd_koordinasi)
    {
        DB::table('koordinasi_ta')->where('kd_koordinasi', $kd_koordinasi)->delete();
        return redirect('/sys-admin/daftarKoordinasi')->with('success', 'Koordinasi berhasil dihapus.');
    }
}
