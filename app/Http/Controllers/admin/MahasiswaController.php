<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {   $mahasiswas = DB::table('mahasiswa')->get();
        return view('admin.mahasiswa.index', ["mahasiswas" => $mahasiswas]);
    }

    public function create()
    {
        return view('admin.mahasiswa.tambahMahasiswa');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npm' => 'required|unique:mahasiswa',
            'nama' => 'required',
            'prodi' => 'required',
            'password' => 'required',
            'no_hp' => 'required',
        ],[
            'npm.unique' => 'NPM ini sudah terdaftar. Gunakan NPM lain.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::table('mahasiswa')->insert([
            'npm' => $request['npm'],
            'nama' => $request['nama'],
            'prodi' => $request['prodi'],
            'password' => Hash::make($request['password']),
            'token' => Str::random(16),
            'no_hp' => $request['no_hp'],
        ]);
    
        return redirect('/mahasiswa')->with('success', 'Mahasiswa baru berhasil ditambahkan.');
    }

    public function edit($token)
    {
        $mahasiswa = DB::table('mahasiswa')->where('token', $token)->first();
        return view('admin.mahasiswa.editMahasiswa', compact('mahasiswa'));
    }

    public function update(Request $request, $token)
    {

        $data = [
            'npm' => $request->npm,
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        DB::table('mahasiswa')->where('token', $token)->update($data);
    
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy($npm)
    {
        DB::table('mahasiswa')->where('npm', $npm)->delete();
    
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
