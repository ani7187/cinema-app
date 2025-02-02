<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\SeatBookingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\DashboardController::class, 'rooms'])->name('home');
Route::get('/schedules/{room}', [App\Http\Controllers\DashboardController::class, 'schedules'])->name('room.schedules');
Route::get('/schedule/{schedule}', [App\Http\Controllers\DashboardController::class, 'showSeats'])->name('schedule.seats');
Route::post('/book-seat', [SeatBookingController::class, 'book'])->name('book.seat');

Route::redirect('/admin', '/admin/login', 301);
Route::prefix('admin')->group(function () {
    Auth::routes();
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::resource('rooms', RoomController::class)->except(['show']);
    Route::resource('movies', MovieController::class)->except(['show']);
    Route::resource('schedules', ScheduleController::class)->except(['show']);

    Route::get('/schedule/bookings/{schedule}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

//    Route::resource('bookings', BookingController::class)->except(['show', 'edit', 'update', 'create', 'store']);
});

Route::fallback(function () {
    abort(404);
});
