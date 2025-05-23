<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AuthSeeder;
use Database\Seeders\DosenSeeder;
use Database\Seeders\MahasiswaSeeder;
use Database\Seeders\DaftarBimbinganSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            DosenSeeder::class,
            MahasiswaSeeder::class,
            DaftarBimbinganSeeder::class,
            DetailDaftarSeeder::class,
            AuthSeeder::class,
        ]);
    }
}
