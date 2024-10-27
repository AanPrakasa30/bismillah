<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        if (\Illuminate\Support\Facades\App::isLocal()) {
            $this->call(SiswaSeeder::class);

            $this->call([
                KasusSeeder::class,
                HomeSeeder::class,
                KonselingSeeder::class
            ]);
        }
    }
}
