<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DaftarBimbingan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        // $dosenList = Dosen::all();

        $dosenList = Dosen::limit(5)->get(); // hanya 5 data dosen yang di ambil

        $lastNumbers = []; // Simpan nomor terakhir per kodeProdi

        foreach ($dosenList as $dosen) {
            // Format kode prodi
            $prodi = strtolower(trim($dosen->prodi));
            if ($prodi === 'arsitektur') {
                $kodeProdi = strtoupper(substr($prodi, 0, 3));
            } else {
                $kodeProdi = '';
                foreach (explode(' ', $prodi) as $part) {
                    $kodeProdi .= strtoupper(substr($part, 0, 1));
                }
            }

            // Cek nomor terakhir dari kodeProdi
            if (!isset($lastNumbers[$kodeProdi])) {
                $last = DB::table('daftar_bimbingan')
                    ->where('kd_bimbingan', 'like', 'BIM' . $kodeProdi . '%')
                    ->orderByDesc('kd_bimbingan')
                    ->first();

                $lastNumbers[$kodeProdi] = $last
                    ? (int) substr($last->kd_bimbingan, -4)
                    : 0;
            }

            // Buat 2 data: pembimbing 1 dan 2
            foreach ([1, 2] as $pembimbing) {
                $lastNumbers[$kodeProdi]++;
                $nextNumber = str_pad($lastNumbers[$kodeProdi], 4, '0', STR_PAD_LEFT);
                $kd_bimbingan = 'BIM' . $kodeProdi . $nextNumber;
                $slug = 'S' . $kodeProdi . $nextNumber;

                DaftarBimbingan::create([
                    'kd_bimbingan' => $kd_bimbingan,
                    'nip' => $dosen->nip,
                    'slug' => $slug,
                    'pembimbing' => $pembimbing,
                    'tgl_pembuatan' => now()->toDateString(),
                ]);
            }
        }
    }
}
