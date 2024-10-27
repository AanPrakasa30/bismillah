<?php

namespace Database\Seeders;

use App\Models\Konseling;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KonselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Konseling::factory(30)->create();
    }
}
