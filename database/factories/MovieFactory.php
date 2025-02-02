<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'poster_url' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence,
            'genre_id' => $this->faker->randomElement(\App\Models\Genre::pluck('id')->toArray()),
            'min_allowed_age' => $this->faker->numberBetween(0, 18),
        ];
    }
}
