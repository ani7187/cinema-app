<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomSeats;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(StoreRoomRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $room = Room::create($data);

            $rows = $request->input('rows');
            $seatsPerRow = $request->input('seats_per_row');

            for ($row = 1; $row <= $rows; $row++) {
                for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                    RoomSeats::create([
                        'room_id' => $room->id,
                        'row' => $row,
                        'seat' => $seat,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully with seats.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {

        try {
            if ($room->schedules()->where('start_time', '>=', now())->exists()) {
                return redirect()->back()->withErrors(['room' => 'Room cannot be updated because it has related schedules in the future.']);
            }

            DB::beginTransaction();
            $data = $request->validated();

            // Check if rows or seats per row changed
            $rowsChanged = isset($data['rows']) && $data['rows'] !== $room->rows;
            $seatsPerRowChanged = isset($data['seats_per_row']) && $data['seats_per_row'] !== $room->seats_per_row;

            if (($rowsChanged || $seatsPerRowChanged) && !$room->schedules()->exists()) {
                // Delete existing seats
                $room->seats()->delete();

                // Recreate the seats based on the new configuration
                $rows = $data['rows'] ?? $room->rows;
                $seatsPerRow = $data['seats_per_row'] ?? $room->seats_per_row;

                for ($row = 1; $row <= $rows; $row++) {
                    for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                        RoomSeats::create([
                            'room_id' => $room->id,
                            'row' => $row,
                            'seat' => $seat,
                        ]);
                    }
                }
            }

            $room->update($data);

            DB::commit();

            return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Room update failed: ' . $e->getMessage());

            return back()->with('error', 'There was an error updating the room.');
        }
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
