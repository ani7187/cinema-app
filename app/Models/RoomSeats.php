<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSeats extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'row', 'seat'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_seat_id');
    }

    public function isAvailableForSchedule($scheduleId)
    {
        return $this->bookings()->where('schedule_id', $scheduleId)->doesntExist();
    }
}
