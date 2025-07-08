<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = DB::table('mahasiswa')
        ->join('prodi','mahasiswa.kd_prodi','=','prodi.kd_prodi')
        ->get();

        $prodi = DB::table('prodi')->orderBy('kd_prodi')->get();

        return view('admin.mahasiswa.mahasiswa',['mahasiswas' => $mahasiswas,'prodi' => $prodi]);
    }

    public function tambahMahasiswa()
    {
        $prodi = DB::table('prodi')->orderBy('kd_prodi')->get();
        return view('admin.mahasiswa.tambah',['prodi' => $prodi]);
    }

    public function mahasiswaBaru(Request $request)
    {
        DB::table('mahasiswa')->insert([
            'npm' => $request->npm,
            'nama' => $request->nama,
            'password' => Hash::make($request->npm),
            'kd_prodi' => $request->kd_prodi
        ]);

        return redirect('/sys-admin/daftarMahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function editMahasiswa(Request $request,$npm)
    {
        $mahasiswa = DB::table('mahasiswa')->where('npm', $npm)->first();
        $prodi = DB::table('prodi')->get();

        return view('admin.mahasiswa.edit', compact('mahasiswa', 'prodi'));
    }

    public function update(Request $request, $npm)
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

        DB::table('mahasiswa')->where('npm', $npm)->update($data);

        return redirect('/sys-admin/daftarMahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy($npm)
    {
        DB::table('mahasiswa')->where('npm', $npm)->delete();
        return redirect('/sys-admin/daftarMahasiswa')->with('success', 'Mahasiswa berhasil dihapus.');
    }

}
