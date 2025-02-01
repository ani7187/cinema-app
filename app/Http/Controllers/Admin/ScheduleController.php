<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $rooms = Room::all();
        $movies = Movie::all();

        return view('admin.schedules.create', compact('rooms', 'movies'));
    }

    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();
        Schedule::create($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        $room = $schedule->room;
        $seats = $room->seats;

        return view('admin.schedules.show', compact('seats', 'schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $rooms = Room::all();
        $movies = Movie::all();

        return view('admin.schedules.edit', compact('schedule', 'rooms', 'movies'));
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();
        $schedule->update($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }

}
