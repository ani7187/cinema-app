<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rows', 'seats_per_row', 'published'];

    /**
     * @return HasMany
     */
    public function seats(): HasMany
    {
        return $this->hasMany(RoomSeats::class);
    }

    /**
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Check if the room has any active schedules.
     *
     * @return bool
     */
    public function hasActiveSchedules(): bool
    {
        return $this->schedules()->where('end_time', '>', now())->exists();
    }
}
