<?php

namespace Database\Seeders;

use App\Models\DetailDaftar;
use App\Models\DaftarBimbingan;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailDaftarSeeder extends Seeder
{
    public function run(): void
    {
        $bimbinganList = DaftarBimbingan::with('dosen')->get();

        foreach ($bimbinganList as $bimbingan) {
            $prodiDosen = strtolower(trim($bimbingan->dosen->prodi));
            $pembimbingKe = $bimbingan->pembimbing;

            // Ambil mahasiswa yang sama prodi dengan dosen
            $mahasiswaCandidates = Mahasiswa::whereRaw('LOWER(TRIM(prodi)) = ?', [$prodiDosen])->get();

            $addedCount = 0;

            foreach ($mahasiswaCandidates->shuffle() as $mhs) {
                // Cek apakah mahasiswa ini sudah punya pembimbing ke-1
                $pembimbing1Exists = DB::table('detail_daftar')
                    ->join('daftar_bimbingan', 'detail_daftar.kd_bimbingan', '=', 'daftar_bimbingan.kd_bimbingan')
                    ->where('detail_daftar.npm', $mhs->npm)
                    ->where('daftar_bimbingan.pembimbing', 1)
                    ->exists();

                // Jika pembimbing sekarang = 1 dan mahasiswa sudah punya pembimbing 1 => skip
                if ($pembimbingKe == 1 && $pembimbing1Exists) {
                    continue;
                }

                // Jika pembimbing sekarang = 2 dan mahasiswa belum punya pembimbing 1 => skip
                if ($pembimbingKe == 2 && !$pembimbing1Exists) {
                    continue;
                }

                // Cek duplikat di bimbingan ini
                $alreadyAdded = DB::table('detail_daftar')
                    ->where('kd_bimbingan', $bimbingan->kd_bimbingan)
                    ->where('npm', $mhs->npm)
                    ->exists();

                if (!$alreadyAdded) {
                    DetailDaftar::create([
                        'kd_bimbingan' => $bimbingan->kd_bimbingan,
                        'npm' => $mhs->npm,
                    ]);

                    $addedCount++;
                }

                // Batas 3–6 mahasiswa per bimbingan
                if ($addedCount >= rand(3, 6)) {
                    break;
                }
            }
        }
    }
}
