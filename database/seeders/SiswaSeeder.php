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
            AngkatanSeeder::class,
            KelasSeeder::class
        ]);

        \App\Models\Master\Siswa::factory(50)->create()->each(function ($siswa) {
            $angkatan = \App\Models\Master\Angkatan::orderBy('tahun')->limit(3)->get()->pluck('id');
            $kelas    = \App\Models\Master\Kelas::inRandomOrder()->take(3)->pluck('id');

            foreach ($angkatan as $angkatanId) {
                foreach ($kelas as $kelasId) {
                    if (
                        !\App\Models\Relasi\KelasSiswa::where([
                            'siswa_id' => $siswa->id,
                            'angkatan_id' => $angkatanId
                        ])->exists()
                    ) {
                        // buat baru
                        \App\Models\Relasi\KelasSiswa::create([
                            'siswa_id' => $siswa->id,
                            'kelas_id' => $kelasId,
                            'angkatan_id' => $angkatanId
                        ]);
                    }
                }
            }
        });
    }
}
