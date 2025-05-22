<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $dosens = [];
    
        DB::table('dosen')->orderBy('nip')->chunk(10, function ($chunk) use (&$dosens) {
            foreach ($chunk as $dosen) {
                $dosens[] = $dosen; // Menyimpan data ke array dosens
            }
        });
    
        // Kirim data ke view
        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosen.tambahDosen');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:dosen',
            'nama' => 'required',
            'prodi' => 'required',
            'no_hp' => 'required',
        ],[
            'nip.unique' => 'NIP ini sudah terdaftar. Gunakan NIP lain.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::table('dosen')->insert([
            'nip' => $request['nip'],
            'nama' => $request['nama'],
            'prodi' => $request['prodi'],
            'password' => Hash::make($request['nip']),
            'token' => Str::random(16),
            'no_hp' => $request['no_hp'],
        ]);
    
        return redirect('/dosen')->with('success', 'Dosen baru berhasil ditambahkan.');
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
    public function edit($token)
    {
        $dosen = DB::table('dosen')->where('token', $token)->first();
        return view('admin.dosen.editDosen', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $token)
    {

        $data = [
            'nip' => $request->nip,
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        DB::table('dosen')->where('token', $token)->update($data);
    
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nip)
    {
        DB::table('dosen')->where('nip', $nip)->delete();
    
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}
