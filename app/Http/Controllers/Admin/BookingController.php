<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $schedules = Schedule::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.bookings.index', compact('schedules'));
    }

    /**
     * @param Request $request
     * @param Schedule $schedule
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Request $request, Schedule $schedule): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $seatsQuery = $schedule->room->seats();
        $filter = $request->query('filter', 'all');

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

    /**
     * @param Booking $booking
     * @return JsonResponse
     */
    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();

        return response()->json(['success' => true, 'message' => 'Seat booked successfully.']);
    }
}

