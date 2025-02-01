<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Room;
use App\Models\RoomSeats;
use App\Models\Schedule;
use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create rooms
        Room::create(['name' => 'Red Room', 'rows' => 10, 'seats_per_row' => 8]);
        Room::create(['name' => 'Blue Room', 'rows' => 8, 'seats_per_row' => 10]);

        // Create movies
        $movie1 = Movie::create(['title' => 'Movie 1', 'poster_url' => 'movie1.jpg']);
        $movie2 = Movie::create(['title' => 'Movie 2', 'poster_url' => 'movie2.jpg']);

        // Create schedules for rooms and movies
        Schedule::create(['room_id' => 1, 'movie_id' => $movie1->id, 'start_time' => '2025-01-31 12:00:00', 'end_time' => '2025-01-31 12:00:00']);
        Schedule::create(['room_id' => 1, 'movie_id' => $movie2->id, 'start_time' => '2025-01-31 14:00:00', 'end_time' => '2025-01-31 12:00:00']);

        // Create seats for rooms (example)
        foreach (Room::all() as $room) {
            for ($row = 1; $row <= $room->rows; $row++) {
                for ($seat = 1; $seat <= $room->seats_per_row; $seat++) {
                    RoomSeats::create(['room_id' => $room->id, 'row' => $row, 'seat' => $seat]);
                }
            }
        }
    }
}
