<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DosenSeeder;
use Database\Seeders\ProdiSeeder;
use Database\Seeders\MahasiswaSeeder;
use Database\Seeders\PembimbingSeeder;
use Database\Seeders\KoordinasiTaSeeder;

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

        $this->call(ProdiSeeder::class);
        $this->call(DosenSeeder::class);
        $this->call(KoordinasiTaSeeder::class);
        $this->call(PembimbingSeeder::class);
        $this->call(MahasiswaSeeder::class);
    }
}
