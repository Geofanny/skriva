<?php

namespace Database\Factories;

use App\Models\DaftarBimbingan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class DaftarBimbinganFactory extends Factory
{
    protected $model = DaftarBimbingan::class;

    public function definition(): array
    {
        return [
            'tgl_pembuatan' => Carbon::today()->format('Y-m-d'),
        ];
    }
}
