<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            KelasSeeder::class
        ]);

        $angkatans = [
            2012,
            2013,
            2014
        ];

        \App\Models\Master\Siswa::factory(50)->create()->each(function ($siswa) use ($angkatans) {
            $kelas = \App\Models\Master\Kelas::inRandomOrder()->take(3)->pluck('id');

            foreach ($angkatans as $tahun) {
                foreach ($kelas as $kelasId) {
                    if (
                        !\App\Models\Relasi\KelasSiswa::where([
                            'siswa_id' => $siswa->id,
                            'tahun' => $tahun
                        ])->exists()
                    ) {
                        // buat baru
                        \App\Models\Relasi\KelasSiswa::create([
                            'siswa_id' => $siswa->id,
                            'kelas_id' => $kelasId,
                            'tahun' => $tahun
                        ]);
                    }
                }
            }
        });
    }
}
