<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'movie_id', 'start_time', 'end_time', 'published'];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return BelongsTo
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return mixed
     */
    public function getStartTimeFormattedAttribute(): mixed
    {
        return $this->start_time->format('Y-m-d H:i');
    }

    /**
     * @return mixed
     */
    public function getEndTimeFormattedAttribute(): mixed
    {
        return $this->end_time->format('Y-m-d H:i');
    }

    /**
     * @return bool
     */
    private function isActive(): bool
    {
        return $this->end_time > now();
    }
}
