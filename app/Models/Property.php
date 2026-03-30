<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'total_rooms',
        'occupied_rooms',
        'icon',
        'description',
        'contact_phone',
        'contact_email',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'total_rooms' => 'integer',
        'occupied_rooms' => 'integer',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function getOccupancyRateAttribute(): int
    {
        if ($this->total_rooms === 0) {
            return 0;
        }
        return round(($this->occupied_rooms / $this->total_rooms) * 100);
    }

    public function getAvailableRoomsAttribute(): int
    {
        return $this->total_rooms - $this->occupied_rooms;
    }
}
