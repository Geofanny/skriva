<?php

namespace App\Http\Controllers\mahasiswa;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function showProfil()
    {
        $npmMahasiswa = Auth::guard('mahasiswa')->user()->npm;
        $mahasiswa = DB::table('mahasiswa')->where('npm',$npmMahasiswa)->first();

        return view('mahasiswa.editProfil',compact('mahasiswa'));
    }

    public function updateProfilMahasiswa(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'no_hp' => 'nullable|regex:/^[0-9]{1,18}$/',
            'cropped_foto' => 'nullable|string', // hanya divalidasi, jangan dimasukkan ke $data
        ]);

        $data = [
            'nama' => $validated['nama'],
            'no_hp' => $validated['no_hp'] ?? null,
        ];


        if ($request->filled('cropped_foto')) {
            $croppedData = $request->input('cropped_foto');
        
            // Ambil format gambar dari base64
            preg_match("/^data:image\/(\w+);base64,/", $croppedData, $type);
            $imageData = substr($croppedData, strpos($croppedData, ',') + 1);
            $type = strtolower($type[1] ?? '');
        
            // Validasi hanya menerima JPG/JPEG
            if (!in_array($type, ['jpg', 'jpeg'])) {
                abort(400, 'Format gambar hanya mendukung JPG');
            }
        
            $decodedImage = base64_decode($imageData);
            if ($decodedImage === false) {
                abort(400, 'Gagal decoding gambar');
            }
        
            // Simpan file dengan nama unik
            $filename = Str::uuid() . '.jpg';
            Storage::disk('public')->put("fotoProfil/{$filename}", $decodedImage);
        
            // Hapus foto lama jika ada
            if ($mahasiswa->foto && Storage::disk('public')->exists("fotoProfil/{$mahasiswa->foto}")) {
                Storage::disk('public')->delete("fotoProfil/{$mahasiswa->foto}");
            }
        
            // Tambahkan ke data yang akan diupdate
            $data['foto'] = $filename;
        }        

        DB::table('mahasiswa')->where('npm', $mahasiswa->npm)->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

}
