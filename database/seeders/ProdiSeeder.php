<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Pembimbing;
use App\Models\KoordinasiTA;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar prodi dan fakultas sesuai dari HTML
        $list = [
            ['nama_prodi' => 'Bimbingan dan Konseling', 'fakultas' => 'Ilmu Pendidikan dan Pengetahuan Sosial'],
            ['nama_prodi' => 'Pendidikan Ekonomi', 'fakultas' => 'Ilmu Pendidikan dan Pengetahuan Sosial'],
            ['nama_prodi' => 'Pendidikan Sejarah', 'fakultas' => 'Ilmu Pendidikan dan Pengetahuan Sosial'],
            ['nama_prodi' => 'Bisnis Digital', 'fakultas' => 'Ilmu Pendidikan dan Pengetahuan Sosial'],
            ['nama_prodi' => 'Manajemen Ritel', 'fakultas' => 'Ilmu Pendidikan dan Pengetahuan Sosial'],
            ['nama_prodi' => 'Pendidikan Matematika', 'fakultas' => 'Matematika dan Ilmu Pengetahuan Alam'],
            ['nama_prodi' => 'Pendidikan Biologi', 'fakultas' => 'Matematika dan Ilmu Pengetahuan Alam'],
            ['nama_prodi' => 'Pendidikan Fisika', 'fakultas' => 'Matematika dan Ilmu Pengetahuan Alam'],
            ['nama_prodi' => 'Sains Data', 'fakultas' => 'Matematika dan Ilmu Pengetahuan Alam'],
            ['nama_prodi' => 'Arsitektur', 'fakultas' => 'Teknik dan Ilmu Komputer'],
            ['nama_prodi' => 'Teknik Industri', 'fakultas' => 'Teknik dan Ilmu Komputer'],
            ['nama_prodi' => 'Teknik Informatika', 'fakultas' => 'Teknik dan Ilmu Komputer'],
            ['nama_prodi' => 'Sistem Informasi', 'fakultas' => 'Teknik dan Ilmu Komputer'],
            ['nama_prodi' => 'Pendidikan Bahasa dan Sastra Indonesia', 'fakultas' => 'Bahasa dan Seni'],
            ['nama_prodi' => 'Pendidikan Bahasa Inggris', 'fakultas' => 'Bahasa dan Seni'],
            ['nama_prodi' => 'Desain Komunikasi Visual', 'fakultas' => 'Bahasa dan Seni'],
        ];

        $kodeMap = [
            'Ilmu Pendidikan dan Pengetahuan Sosial' => 'IPPS',
            'Matematika dan Ilmu Pengetahuan Alam' => 'MIPA',
            'Teknik dan Ilmu Komputer' => 'TIK',
            'Bahasa dan Seni' => 'BS',
        ];

        $counter = [];

        for ($i = 0; $i < count($list); $i++) {
            $data = $list[$i % count($list)];

            $prefix = $kodeMap[$data['fakultas']];

            // Nomor urut per fakultas
            if (!isset($counter[$prefix])) {
                $counter[$prefix] = 1;
            } else {
                $counter[$prefix]++;
            }

            $kd_prodi = $prefix . str_pad($counter[$prefix], 2, '0', STR_PAD_LEFT);

            Prodi::create([
                'kd_prodi' => $kd_prodi,
                'nama_prodi' => $data['nama_prodi'],
                'fakultas' => $data['fakultas'],
            ]);
        }

        // Pembimbing
        Mahasiswa::create([
            'npm' => '202333500111',
            'nama' => 'Alexander',
            'foto' => null,
            'password' => Hash::make('202333500111'),
            'kd_prodi' => 'MIPA02',
        ]);

        User::create([
            'name' => 'Jamal Komarudin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123')
        ]);

        // Pembimbing
        Dosen::create([
            'nip' => '187105202013041006',
            'nama' => 'Kemal Palevi',
            'foto' => null,
            'password' => Hash::make('187105202013041006'),
            'kd_prodi' => 'MIPA02',
        ]);

        // Koordinasi
        Dosen::create([
            'nip' => '177105202013041006',
            'nama' => 'Rudi Palevi',
            'foto' => null,
            'password' => Hash::make('177105202013041006'),
            'kd_prodi' => 'MIPA01',
        ]);

        Pembimbing::create([
            'kd_pembimbing' => 'PB15100601',
            'nip' => '187105202013041006',
            'posisi' => 'Pembimbing 1',
        ]);

        KoordinasiTA::create([
            'kd_koordinasi'=> 'KR121005',
            'kd_prodi' => 'MIPA01',
            'nip' => '177105202013041006',
        ]);
    }
}
