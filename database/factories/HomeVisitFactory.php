<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomeVisit>
 */
class HomeVisitFactory extends Factory
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
            'wali' => fake()->name(),
            'alamat' => fake()->address(),
            'kasus' => fake()->paragraph(1),
        ];
    }
}
