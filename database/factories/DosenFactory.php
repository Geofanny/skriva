<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class DosenFactory extends Factory
{
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID');

        // Daftar Prodi dan Gelar yang relevan
        $prodiGelar = [
            'bimbingan dan konseling' => ['M.Pd.', 'Dr.'],
            'pendidikan ekonomi' => ['M.Pd.', 'Dr.'],
            'pendidikan sejarah' => ['M.Pd.', 'Dr.'],
            'bisnis digital' => ['M.M.', 'M.Kom.', 'Ph.D.'],
            'manajemen ritel' => ['M.M.', 'Dr.'],
            'pendidikan matematika' => ['M.Pd.', 'Dr.'],
            'pendidikan biologi' => ['M.Pd.', 'Dr.'],
            'pendidikan fisika' => ['M.Pd.', 'Dr.'],
            'sains data' => ['M.Si.', 'Ph.D.'],
            'arsitektur' => ['M.T.', 'Dr.'],
            'teknik industri' => ['M.T.', 'Ph.D.'],
            'teknik informatika' => ['M.Kom.', 'Ph.D.'],
            'sistem informasi' => ['M.Kom.', 'Ph.D.'],
            'pendidikan bahasa dan sastra indonesia' => ['M.Pd.', 'Dr.'],
            'pendidikan bahasa inggris' => ['M.Pd.', 'Dr.'],
            'desain komunikasi visual' => ['M.Sn.', 'Dr.'],
        ];

        // Pilih prodi secara acak
        $prodi = $faker->randomElement(array_keys($prodiGelar));

        // Ambil gelar sesuai prodi
        $gelar = $faker->randomElement($prodiGelar[$prodi]);

        // Buat nama lengkap sesuai gelar
        $namaDepan = $faker->firstName();
        $namaBelakang = $faker->lastName();

        if ($gelar === 'Dr.') {
            $namaLengkap = $gelar . ' ' . $namaDepan . ' ' . $namaBelakang;
        } elseif ($gelar === 'Ph.D.') {
            $namaLengkap = $namaDepan . ' ' . $namaBelakang . ', ' . $gelar;
        } else {
            $namaLengkap = $namaDepan . ' ' . $namaBelakang . ', ' . $gelar;
        }

        $nip = $faker->unique()->numerify('################');

        return [
            'nip' => $nip,
            'nama' => $namaLengkap,
            'prodi' => $prodi,
            'password' => bcrypt($nip),
            'token' => Str::random(16),
            'foto' => null,
            'no_hp' => $faker->numerify('08##########'),
        ];
    }
}
