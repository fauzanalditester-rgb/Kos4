<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'condition',
        'price',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:0',
    ];

    public function getConditionLabelAttribute(): string
    {
        return match($this->condition) {
            'new' => 'Baru',
            'good' => 'Baik',
            'fair' => 'Cukup',
            'poor' => 'Kurang',
            'broken' => 'Rusak',
            default => 'Baik',
        };
    }

    public function getConditionColorAttribute(): string
    {
        return match($this->condition) {
            'new' => 'bg-[#0d9488]/20 text-[#14b8a6]',
            'good' => 'bg-[#0d9488]/20 text-[#14b8a6]',
            'fair' => 'bg-yellow-500/20 text-yellow-400',
            'poor' => 'bg-orange-500/20 text-orange-400',
            'broken' => 'bg-red-500/20 text-red-400',
            default => 'bg-[#0d9488]/20 text-[#14b8a6]',
        };
    }
}
