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
            'Bimbingan dan Konseling' => ['M.Pd.', 'Dr.'],
            'Pendidikan Ekonomi' => ['M.Pd.', 'Dr.'],
            'Pendidikan Sejarah' => ['M.Pd.', 'Dr.'],
            'Bisnis Digital' => ['M.M.', 'M.Kom.', 'Ph.D.'],
            'Manajemen Ritel' => ['M.M.', 'Dr.'],
            'Pendidikan Matematika' => ['M.Pd.', 'Dr.'],
            'Pendidikan Biologi' => ['M.Pd.', 'Dr.'],
            'Pendidikan Fisika' => ['M.Pd.', 'Dr.'],
            'Sains Data' => ['M.Si.', 'Ph.D.'],
            'Arsitektur' => ['M.T.', 'Dr.'],
            'Teknik Industri' => ['M.T.', 'Ph.D.'],
            'Teknik Informatika' => ['M.Kom.', 'Ph.D.'],
            'Sistem Informasi' => ['M.Kom.', 'Ph.D.'],
            'Pendidikan Bahasa dan Sastra Indonesia' => ['M.Pd.', 'Dr.'],
            'Pendidikan Bahasa Inggris' => ['M.Pd.', 'Dr.'],
            'Desain Komunikasi Visual' => ['M.Sn.', 'Dr.'],
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

        return [
            'nip' => $faker->unique()->numerify('################'),
            'nama' => $namaLengkap,
            'prodi' => $prodi,
            'password' => bcrypt('password123'),
            'token' => Str::random(16),
            'foto' => null,
            'no_hp' => $faker->numerify('08##########'),
        ];
    }
}
