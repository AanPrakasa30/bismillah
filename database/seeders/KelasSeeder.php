<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

        foreach ($datas as $kelas) {
            \App\Models\Master\Kelas::factory()->create(['nama' => $kelas]);
        }
    }
}
