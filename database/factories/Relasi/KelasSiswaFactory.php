<?php

namespace Database\Factories\Relasi;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Relasi\KelasSiswa>
 */
class KelasSiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'siswa_id' => \App\Models\Master\Siswa::factory(),
            'kelas_id' => \App\Models\Master\Kelas::factory(),
            'angkatan_id' => \App\Models\Master\Angkatan::factory()
        ];
    }
}
