<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'code',
        'type',
        'price_monthly',
        'status',
        'facilities',
        'description',
        'floor',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:0',
        'floor' => 'integer',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Kosong',
            'occupied' => 'Terisi',
            'maintenance' => 'Perbaikan',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'bg-green-500/10 text-green-400 border-green-500/20',
            'occupied' => 'bg-[#0d9488]/10 text-[#0d9488] border-[#0d9488]/20',
            'maintenance' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
            default => 'bg-gray-500/10 text-gray-400',
        };
    }
}
