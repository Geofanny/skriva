<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index()
    {
        $daftarDosen = DB::table('dosen')
        ->join('prodi','dosen.kd_prodi','=','prodi.kd_prodi')
        ->get();

        $daftarProdi = DB::table('prodi')->get();
        
        return view('admin.dosen.dosen',compact('daftarDosen','daftarProdi'));
    }

    public function tambahDosen()
    {
        $daftarProdi = DB::table('prodi')->get();

        return view('admin.dosen.tambah', compact('daftarProdi'));
    }

    public function dosenBaru(Request $request)
    {
        DB::table('dosen')->insert([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'password' => Hash::make($request->nip),
            'kd_prodi' => $request->kd_prodi
        ]);

        return redirect('/sys-admin/daftarDosen')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function editDosen(Request $request,$nip)
    {
        $dosen = DB::table('dosen')->where('nip', $nip)->first();
        $prodi = DB::table('prodi')->get();

        return view('admin.dosen.edit', compact('dosen', 'prodi'));
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

        return redirect('/sys-admin/daftarDosen')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($nip)
    {
        DB::table('dosen')->where('nip', $nip)->delete();
        return redirect('/sys-admin/daftarDosen')->with('success', 'Dosen berhasil dihapus.');
    }
}
