<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'movie_id', 'start_time', 'end_time', 'published'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getStartTimeFormattedAttribute()
    {
        return $this->start_time->format('Y-m-d H:i');
    }

    public function getEndTimeFormattedAttribute()
    {
        return $this->end_time->format('Y-m-d H:i');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
