<?php

namespace Database\Factories;

use App\Models\DetailDaftar;
use App\Models\DaftarBimbingan;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailDaftarFactory extends Factory
{
    protected $model = DetailDaftar::class;

    public function definition(): array
    {
        $kd_bimbingan = DaftarBimbingan::inRandomOrder()->value('kd_bimbingan');
        $npm = Mahasiswa::inRandomOrder()->value('npm');

        return [
            'kd_bimbingan' => $kd_bimbingan,
            'npm' => $npm,
        ];
    }
}
