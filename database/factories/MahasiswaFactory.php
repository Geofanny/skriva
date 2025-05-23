<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID');
    
        $prefix = '202333500';
    
        // Ambil semua npm yang sudah pernah dibuat untuk mencegah duplikat secara global saat seeding ulang
        static $usedNpm = [];
    
        // Generate npm unik
        do {
            $suffix = str_pad($faker->numberBetween(0, 999), 3, '0', STR_PAD_LEFT); // 3 digit tetap, misal 001
            $npm = $prefix . $suffix;
        } while (in_array($npm, $usedNpm));
    
        $usedNpm[] = $npm;
    
        return [
            'npm' => $npm,
            'nama' => $faker->name(),
            'prodi' => $faker->randomElement([
                'bimbingan dan konseling',
                'pendidikan ekonomi',
                'pendidikan sejarah',
                'bisnis digital',
                'manajemen ritel',
                'pendidikan matematika',
                'pendidikan biologi',
                'pendidikan fisika',
                'sains data',
                'arsitektur',
                'teknik industri',
                'teknik informatika',
                'sistem informasi',
                'pendidikan bahasa dan sastra indonesia',
                'pendidikan bahasa inggris',
                'desain komunikasi visual'
            ]),
            'password' => bcrypt($npm),
            'token' => Str::random(16),
            'foto' => null,
            'no_hp' => $faker->numerify('08##########'),
        ];
    }    
}
