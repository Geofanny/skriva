<?php

namespace App\Http\Controllers\dosen;

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
        $nipDosen = Auth::guard('dosen')->user()->nip;
        $dosen = DB::table('dosen')->where('nip',$nipDosen)->first();
        $riwayatPendidikan = DB::table('riwayat_pendidikan')->where('nip',$nipDosen)->get();

        return view('dosen.editProfil',compact([
            'dosen',
            'riwayatPendidikan'
        ]));
    }


    public function updateProfilDosen(Request $request)
    {
        $nip = Auth::guard('dosen')->user()->nip;

        // Update data dasar dosen
        DB::table('dosen')->where('nip', $nip)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        
        // Upload dan Ganti Foto Profil

        if ($request->filled('cropped_foto')) {
            $croppedData = $request->input('cropped_foto');
        
            // Ambil format dan decode base64
            preg_match("/^data:image\/(\w+);base64,/", $croppedData, $type);
            $data = substr($croppedData, strpos($croppedData, ',') + 1);
            $type = strtolower($type[1]);
        
            if (!in_array($type, ['jpg', 'jpeg'])) {
                abort(400, 'Format gambar hanya mendukung JPG');
            }
        
            $data = base64_decode($data);
            if ($data === false) {
                abort(400, 'Gagal decoding gambar');
            }
        
            // Simpan file
            $namaFile = Str::uuid() . '.jpg';
            Storage::disk('public')->put("fotoProfil/{$namaFile}", $data);
        
            // Ambil data dosen dulu untuk akses foto lama
            $dosen = DB::table('dosen')->where('nip', $nip)->first();
        
            // Hapus foto lama
            if ($dosen && $dosen->foto && Storage::disk('public')->exists("fotoProfil/{$dosen->foto}")) {
                Storage::disk('public')->delete("fotoProfil/{$dosen->foto}");
            }
        
            // Simpan nama file ke database
            DB::table('dosen')->where('nip', $nip)->update([
                'foto' => $namaFile,
            ]);
        }
        

        // Riwayat Pendidikan
        $pendidikanInput = $request->input('pendidikan', []);
        $riwayatLama = DB::table('riwayat_pendidikan')->where('nip', $nip)->get()->keyBy('id_pendidikan');
        $idInputTersedia = [];

        foreach ($pendidikanInput as $pendidikan) {
            if (isset($pendidikan['id']) && $riwayatLama->has($pendidikan['id'])) {
                $id = $pendidikan['id'];
                $dataLama = $riwayatLama[$id];

                // Jika ada perubahan
                if (
                    $dataLama->jenjang !== $pendidikan['jenjang'] ||
                    $dataLama->prodi !== $pendidikan['program_studi'] ||
                    $dataLama->tahun_masuk != $pendidikan['tahun_masuk'] ||
                    $dataLama->tahun_keluar != $pendidikan['tahun_keluar']
                ) {
                    DB::table('riwayat_pendidikan')->where('id_pendidikan', $id)->update([
                        'jenjang' => $pendidikan['jenjang'],
                        'prodi' => $pendidikan['program_studi'],
                        'tahun_masuk' => $pendidikan['tahun_masuk'],
                        'tahun_keluar' => $pendidikan['tahun_keluar'],
                    ]);
                }

                $idInputTersedia[] = $id;
            } else {
                // Insert baru
                DB::table('riwayat_pendidikan')->insert([
                    'nip' => $nip,
                    'jenjang' => $pendidikan['jenjang'],
                    'prodi' => $pendidikan['program_studi'],
                    'tahun_masuk' => $pendidikan['tahun_masuk'],
                    'tahun_keluar' => $pendidikan['tahun_keluar'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Identitas berhasil disimpan .');
    }

}
