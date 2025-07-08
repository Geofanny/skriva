<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $prodiList = DB::table('prodi')->pluck('kd_prodi')->toArray();

        $usedNpm = [];

        for ($i = 0; $i < 200; $i++) {
            // Format NPM: 202333500 + 3 digit random (012 - 999)
            do {
                $randomThree = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                $npm = '202333500' . $randomThree;
            } while (in_array($npm, $usedNpm));

            $usedNpm[] = $npm;

            DB::table('mahasiswa')->insert([
                'npm' => $npm,
                'nama' => $faker->name,
                'password' => Hash::make($npm),
                'foto' => null,
                'kd_prodi' => $faker->randomElement($prodiList),
            ]);
        }
    }
}
