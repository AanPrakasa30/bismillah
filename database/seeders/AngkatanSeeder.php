<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AngkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            '2012',
            '2013',
            '2014'
        ];

        foreach ($datas as $tahun) {
            \App\Models\Master\Angkatan::create(['tahun' => $tahun]);
        }
    }
}
