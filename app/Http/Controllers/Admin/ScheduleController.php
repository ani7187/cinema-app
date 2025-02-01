<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ScheduleController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $schedules = Schedule::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $rooms = Room::orderBy('created_at', 'desc')->get();
        $movies = Movie::orderBy('created_at', 'desc')->get();

        return view('admin.schedules.create', compact('rooms', 'movies'));
    }

    /**
     * @param StoreScheduleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreScheduleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Schedule::create($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    /**
     * @param Schedule $schedule
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Schedule $schedule): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $room = $schedule->room;
        $seats = $room->seats;

        return view('admin.schedules.show', compact('seats', 'schedule'));
    }

    /**
     * @param Schedule $schedule
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(Schedule $schedule): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $rooms = Room::orderBy('created_at', 'desc')->get();
        $movies = Movie::orderBy('created_at', 'desc')->get();

        return view('admin.schedules.edit', compact('schedule', 'rooms', 'movies'));
    }

    /**
     * @param UpdateScheduleRequest $request
     * @param Schedule $schedule
     * @return RedirectResponse
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule): RedirectResponse
    {
        $data = $request->validated();
        $schedule->update($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * @param Schedule $schedule
     * @return RedirectResponse
     */
    public function destroy(Schedule $schedule): RedirectResponse
    {
        if ($schedule->isActive()) {
            return redirect()->back()->with('error', 'Cannot delete active schedule.');
        }
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
