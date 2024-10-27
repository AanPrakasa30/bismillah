<?php

namespace Database\Factories;

use App\Models\Master\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KonselingKel>
 */
class KonselingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::inRandomOrder()->first()->id,
            'nama' => fake()->paragraph(1),
            'kasus' => fake()->paragraph(1),
            'solusi' => fake()->boolean() ? fake()->paragraph(2) : null
        ];
    }
}
