<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' Room',
            'rows' => $this->faker->numberBetween(5, 20),
            'seats_per_row' => $this->faker->numberBetween(5, 15),
            'published' => true,
        ];
    }
}
