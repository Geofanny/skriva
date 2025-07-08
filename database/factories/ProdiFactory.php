<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prodi>
 */
class ProdiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     
    public function definition(): array
    {
        return [
            'nama_prodi' => $this->faker->unique()->words(2, true),
            'fakultas' => 'Ilmu Pendidikan dan Pengetahuan Sosial', // placeholder, nanti di Seeder diubah
            'kd_prodi' => 'TEMP', // placeholder
        ];
    }
}
