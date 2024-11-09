<?php

namespace Database\Factories\Master;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Master\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'NIS' => rand(),
            'nama' => fake()->name(),
            'kelamin' => fake()->boolean() ? 'PRIA' : 'WANITA',
            'alamat' => fake()->address()
        ];
    }
}
