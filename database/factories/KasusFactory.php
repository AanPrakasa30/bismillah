<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kasus>
 */
class KasusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'siswa_id' => \App\Models\Master\Siswa::inRandomOrder()->first()->id,
            'tipe' => fake()->randomElement(['BERAT', 'RINGAN', 'SEDANG']),
            'point' => rand(4, 100),
            'keterangan' => fake()->paragraph()
        ];
    }
}
