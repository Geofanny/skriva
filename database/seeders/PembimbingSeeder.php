<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua NIP dosen yang menjadi koordinator TA
        $nipKoordinator = DB::table('koordinasi_ta')->pluck('nip')->toArray();

        // Ambil semua dosen
        $semuaDosen = DB::table('dosen')->get();

        // Inisialisasi nomor urut global berdasarkan jumlah pembimbing saat ini
        $noUrut = DB::table('pembimbing')->count() + 1;

        foreach ($semuaDosen as $dosen) {
            $nip = $dosen->nip;

            // Skip jika dosen adalah koordinator TA
            if (in_array($nip, $nipKoordinator)) {
                continue;
            }

            // Hitung berapa kali dosen ini sudah menjadi pembimbing
            $jumlahPembimbing = DB::table('pembimbing')->where('nip', $nip)->count();

            // Jika sudah 2 kali jadi pembimbing (baik 1 maupun 2), skip
            if ($jumlahPembimbing >= 2) {
                continue;
            }

            // Tentukan posisi pembimbing berdasarkan jumlah sebelumnya
            $posisi = $jumlahPembimbing === 0 ? 'Pembimbing 1' : 'Pembimbing 2';

            // Buat kode pembimbing
            $kdPembimbing = 'PB' . substr($nip, -6) . str_pad($noUrut, 2, '0', STR_PAD_LEFT);

            // Insert ke tabel pembimbing
            DB::table('pembimbing')->insert([
                'kd_pembimbing' => $kdPembimbing,
                'nip' => $nip,
                'posisi' => $posisi,
            ]);

            $noUrut++;
        }
    }
}
