<?php

namespace Database\Factories;

use App\Models\Film;
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

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Film::STATUS_PENDING,
            ];
        });
    }
}
