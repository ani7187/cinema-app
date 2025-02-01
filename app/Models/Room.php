<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rows', 'seats_per_row', 'published'];

    public function seats()
    {
        return $this->hasMany(RoomSeats::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
