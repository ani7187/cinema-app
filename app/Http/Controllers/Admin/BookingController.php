<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $schedules = Schedule::paginate(10);
        return view('admin.bookings.index', compact('schedules'));
    }

    public function show(Request $request, Schedule $schedule)
    {
        $filter = $request->query('filter', 'all'); // Get filter from request, default to 'all'

        $seatsQuery = $schedule->room->seats();

        if ($filter === 'booked') {
            $seatsQuery->whereHas('bookings', function ($query) use ($schedule) {
                $query->where('schedule_id', $schedule->id);
            });
        } elseif ($filter === 'not_booked') {
            $seatsQuery->whereDoesntHave('bookings', function ($query) use ($schedule) {
                $query->where('schedule_id', $schedule->id);
            });
        }

        $seats = $seatsQuery->paginate(12);

        foreach ($seats as $seat) {
            $seat->booking = $seat->bookings()->where('schedule_id', $schedule->id)->first();
        }

        return view('admin.bookings.show', compact('seats', 'schedule', 'filter'));
    }


    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json(['success' => true, 'message' => 'Seat booked successfully.']);
    }
}

