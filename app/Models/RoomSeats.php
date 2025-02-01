<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomSeats extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'row', 'seat'];

    /**
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'room_seat_id');
    }

    /**
     * @param $scheduleId
     * @return bool
     */
    public function isAvailableForSchedule($scheduleId): bool
    {
        return $this->bookings()->where('schedule_id', $scheduleId)->doesntExist();
    }
}
