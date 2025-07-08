<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jumlah = 20;

        // Ambil semua prodi yang sudah ada
        $prodis = Prodi::all();

        // Mapping kd_prodi ke gelar akademik
        $gelarMap = [
            'informatika' => ['S.Kom.', 'M.Kom.'],
            'sistem informasi' => ['S.Kom.', 'M.Kom.'],
            'arsitektur' => ['S.T.', 'M.T.'],
            'teknik industri' => ['S.T.', 'M.T.'],
            'pendidikan matematika' => ['S.Pd.', 'M.Pd.'],
            'pendidikan biologi' => ['S.Pd.', 'M.Pd.'],
            'pendidikan fisika' => ['S.Pd.', 'M.Pd.'],
            'sains data' => ['S.Si.', 'M.Si.'],
            'bimbingan dan konseling' => ['S.Pd.', 'M.Pd.'],
            'pendidikan ekonomi' => ['S.Pd.', 'M.M.'],
            'pendidikan sejarah' => ['S.Pd.', 'M.Pd.'],
            'bisnis digital' => ['S.E.', 'M.M.'],
            'manajemen ritel' => ['S.E.', 'M.M.'],
            'pendidikan bahasa dan sastra indonesia' => ['S.Pd.', 'M.Pd.'],
            'pendidikan bahasa inggris' => ['S.Pd.', 'M.Pd.'],
            'desain komunikasi visual' => ['S.Sn.', 'M.Sn.'],
        ];

        for ($i = 1; $i <= $jumlah; $i++) {
            $faker = \Faker\Factory::create('id_ID');

            $prodi = $prodis->random();
            $namaProdi = strtolower($prodi->nama_prodi);

            // Cari gelar berdasarkan nama_prodi
            $gelar = $gelarMap[$namaProdi] ?? ['S.Pd.', 'M.Pd.'];
            $namaLengkap = $faker->name . ', ' . implode(', ', $gelar);

            // Format NIP
            $tglLahir = $faker->date('Ymd');      // contoh: 19780520
            $pengangkatan = $faker->date('Ym');   // contoh: 201103
            $gender = rand(1, 2);                 // 1 = L, 2 = P
            $urut = str_pad($i, 3, '0', STR_PAD_LEFT);
            $nip = $tglLahir . $pengangkatan . $gender . $urut;

            Dosen::create([
                'nip' => $nip,
                'nama' => $namaLengkap,
                'password' => Hash::make($nip),
                'foto' => null,
                'kd_prodi' => $prodi->kd_prodi,
            ]);
        }
    }
}
