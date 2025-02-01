<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rooms()
    {
        $rooms = Room::where('published', true)->paginate(6);
        $movies = Movie::inRandomOrder()->limit(4)->pluck('poster_url');

        return view('dashboard.rooms', compact('rooms', 'movies'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function schedules(Room $room)
    {
        $schedules = Schedule::where('room_id', $room->id)
            ->where('published', true)
            ->where('start_time', '>=', Carbon::now())
            ->paginate(3);

        return view('dashboard.schedules', compact('schedules', 'room'));
    }

    public function showSeats(Schedule $schedule)
    {
        $room = $schedule->room;
        $seats = $room->seats;

        return view('dashboard.seats', compact('schedule', 'seats'));
    }
}
