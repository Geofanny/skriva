<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin dummy
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'no_hp' => '081234567890',
        ]);

        // Dosen dummy
        $nip = '123456789';
        Dosen::create([
            'nip' => $nip,
            'nama' => 'Dr. Andi Wijaya',
            'prodi' => 'teknik informatika',
            'password' => Hash::make($nip), // password sama dengan nip
            'token' => Str::random(16),
            'no_hp' => '081234567891',
            'foto' => null,
        ]);

        // Mahasiswa dummy
        $npm = '20233500123';
        Mahasiswa::create([
            'npm' => $npm,
            'nama' => 'Jamal Kamalludin',
            'prodi' => 'sistem informasi',
            'password' => Hash::make($npm), // password sama dengan npm
            'token' => Str::random(16),
            'no_hp' => '081234567892',
            'foto' => null,
        ]);
    }
}
