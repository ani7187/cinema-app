<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'movie_id' => Movie::factory(),
            'start_time' => $this->faker->dateTimeThisYear(),
            'end_time' => $this->faker->dateTimeThisYear(),
            'published' => $this->faker->boolean()
        ];
    }
}
