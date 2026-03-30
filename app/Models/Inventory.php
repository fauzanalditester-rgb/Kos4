<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'property_id',
        'name',
        'category',
        'quantity',
        'unit',
        'price',
        'purchase_date',
        'condition',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:0',
        'purchase_date' => 'date',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function getConditionLabelAttribute(): string
    {
        return match($this->condition) {
            'new' => 'Baru',
            'good' => 'Baik',
            'fair' => 'Cukup',
            'poor' => 'Kurang',
            'broken' => 'Rusak',
            default => 'Unknown',
        };
    }

    public function getConditionColorAttribute(): string
    {
        return match($this->condition) {
            'new' => 'bg-green-500/10 text-green-400',
            'good' => 'bg-blue-500/10 text-blue-400',
            'fair' => 'bg-yellow-500/10 text-yellow-400',
            'poor' => 'bg-orange-500/10 text-orange-400',
            'broken' => 'bg-red-500/10 text-red-400',
            default => 'bg-gray-500/10 text-gray-400',
        };
    }

    public function getTotalValueAttribute(): float
    {
        return $this->price * $this->quantity;
    }
}
