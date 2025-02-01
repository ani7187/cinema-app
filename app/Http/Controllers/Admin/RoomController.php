<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomSeats;
use Illuminate\Contracts\Foundation\Application as App;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    /**
     * @return App|Factory|View|Application
     */
    public function index(): View|Application|Factory|App
    {
        $rooms = Room::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * @return App|Factory|View|Application
     */
    public function create(): View|Application|Factory|App
    {
        return view('admin.rooms.create');
    }

    /**
     * @param StoreRoomRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoomRequest $request): RedirectResponse
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

    /**
     * @param Room $room
     * @return View|Application|Factory|App
     */
    public function edit(Room $room): Application|Factory|View|App
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * @param UpdateRoomRequest $request
     * @param Room $room
     * @return RedirectResponse
     */
    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        try {
            if ($room->hasActiveSchedules()) {
                return redirect()->back()->withErrors(['room' => 'Room cannot be updated because it has related with active schedules.']);
            }

            DB::beginTransaction();
            $data = $request->validated();

            // Check if rows or seats changed
            $rowsChanged = isset($data['rows']) && $data['rows'] !== $room->rows;
            $seatsPerRowChanged = isset($data['seats_per_row']) && $data['seats_per_row'] !== $room->seats_per_row;

            if (($rowsChanged || $seatsPerRowChanged) && !$room->schedules()->exists()) {
                $room->seats()->delete();

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

    /**
     * @param Room $room
     * @return RedirectResponse
     */
    public function destroy(Room $room): RedirectResponse
    {
        if ($room->hasActiveSchedules()) {
            return redirect()->back()->with('error', 'Cannot delete room. There are active schedules.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
