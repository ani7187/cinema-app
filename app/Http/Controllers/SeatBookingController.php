<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoomSeats;
use Illuminate\Http\Request;

class SeatBookingController extends Controller
{

    public function book(Request $request)
    {
        $seatId = $request->input('seat_id');

        // Check if there is already a booking for this seat
        $existingBooking = Booking::where('room_seat_id', $seatId)->first();

        if ($existingBooking) {
            return response()->json(['success' => false, 'message' => 'Seat is already booked.']);
        }

        // Find the seat
        $seat = RoomSeats::find($seatId);

        if (!$seat) {
            return response()->json(['success' => false, 'message' => 'Seat not found.']);
        }

        // Create a new booking
        Booking::create([
            'room_seat_id' => $seatId,
            'schedule_id' => $request->input('schedule_id'),
        ]);

        return response()->json(['success' => true, 'message' => 'Seat booked successfully.']);
    }
}
