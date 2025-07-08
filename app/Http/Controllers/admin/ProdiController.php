<?php

namespace App\Http\Controllers\admin;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = DB::table('prodi')->get();
        return view('admin.prodi.prodi',['prodis' =>$prodis]);
    }

    public function tambahProdi()
    {
        return view('admin.prodi.tambah_prodi');
    }

    public function prodiBaru(Request $request)
    {
        // Mapping fakultas ke kode singkat (tanpa "dan")
        $mapping = [
            'Ilmu Pendidikan dan Pengetahuan Sosial' => 'IPPS',
            'Matematika dan Ilmu Pengetahuan Alam' => 'MIPA',
            'Teknik dan Ilmu Komputer' => 'TIK',
            'Bahasa dan Seni' => 'BS',
        ];

        $fakultas = $request->fakultas;

        if (!isset($mapping[$fakultas])) {
            return back()->withErrors(['fakultas' => 'Fakultas tidak valid']);
        }

        $kodeSingkat = $mapping[$fakultas];

        // Cari kode_prodi terakhir yang diawali dengan kodeSingkat
        $lastKd = DB::table('prodi')
            ->where('kd_prodi', 'like', $kodeSingkat . '%')
            ->orderBy('kd_prodi', 'desc')
            ->value('kd_prodi');

        if ($lastKd) {
            // Ambil angka urut terakhir
            $lastNumber = (int) substr($lastKd, strlen($kodeSingkat));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format nomor 2 digit, misal 01, 02, dst
        $numberStr = str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        $kd_prodi = $kodeSingkat . $numberStr;

        // Simpan data
        DB::table('prodi')->insert([
            'kd_prodi' => $kd_prodi,
            'nama_prodi' => $request->nama_prodi,
            'fakultas' => $fakultas
        ]);

        return redirect('/sys-admin/daftarFakultas')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function editProdi($kd_prodi)
    {
        $prodi = Prodi::findOrFail($kd_prodi);
        return view('admin.prodi.edit_prodi', compact('prodi'));
    }

    public function update(Request $request, $kd_prodi)
    {
        $data = [
           'fakultas' => $request->fakultas,
           'nama_prodi' => $request->nama_prodi
        ];

        DB::table('prodi')->where('kd_prodi', $kd_prodi)->update($data);

        return redirect('/sys-admin/daftarFakultas')->with('success', 'Data prodi berhasil diperbarui.');
    }

    public function destroy($kd_prodi)
    {
        DB::table('prodi')->where('kd_prodi', $kd_prodi)->delete();
        return redirect('/sys-admin/daftarFakultas')->with('success', 'Prodi berhasil dihapus.');
    }


}
