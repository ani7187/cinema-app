<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Room;
use App\Models\RoomSeats;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::factory(2)->create();

        $movie1 = Movie::factory()->create();
        $movie2 = Movie::factory()->create();

        Schedule::factory()->create([
            'room_id' => 1,
            'movie_id' => $movie1->id,
            'start_time' => Carbon::now()->addDays(2)->format('Y-m-d H:i:s'),
            'end_time' => Carbon::now()->addDays(2)->addHours(2)->format('Y-m-d H:i:s'),
            'published' => true,
        ]);

        Schedule::factory()->create([
            'room_id' => 2,
            'movie_id' => $movie2->id,
            'start_time' => Carbon::now()->addDays(2)->addHours(4)->format('Y-m-d H:i:s'),
            'end_time' => Carbon::now()->addDays(2)->addHours(6)->format('Y-m-d H:i:s'),
            'published' => true,
        ]);

        foreach ($rooms as $room) {
            for ($row = 1; $row <= $room->rows; $row++) {
                for ($seat = 1; $seat <= $room->seats_per_row; $seat++) {
                    RoomSeats::factory()->create([
                        'room_id' => $room->id,
                        'row' => $row,
                        'seat' => $seat
                    ]);
                }
            }
        }
    }
}
