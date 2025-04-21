<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'status' => 'ready',
            'description' => fake()->sentences(2, true),
            'director' => fake()->name(),
            'starring' => [fake()->name(), fake()->name(), fake()->name()],
            'run_time' => random_int(60, 240),
            'released' => fake()->year(),
            'imdb_id' => 'tt00' . random_int(1, 9999),
        ];
    }
}
