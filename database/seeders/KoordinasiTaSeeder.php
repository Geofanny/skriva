<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KoordinasiTaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil NIP dosen yang sudah menjadi pembimbing
        $nipPembimbing = DB::table('pembimbing')->pluck('nip')->toArray();

        // Ambil dosen yang belum jadi pembimbing
        $dosenKoordinator = DB::table('dosen')
            ->whereNotIn('nip', $nipPembimbing)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        foreach ($dosenKoordinator as $dosen) {
            $nip = $dosen->nip;
            $kdKoordinasi = 'KR' . substr($nip, -6); // KR + 6 digit terakhir NIP

            DB::table('koordinasi_ta')->insert([
                'kd_koordinasi' => $kdKoordinasi,
                'kd_prodi' => $dosen->kd_prodi,
                'nip' => $nip,
            ]);
        }
    }
}
