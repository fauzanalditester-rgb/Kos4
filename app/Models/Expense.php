<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'date',
        'title',
        'description',
        'category',
        'amount',
        'receipt_photo',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:0',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'staff_salary' => 'Gaji Staff / Penjaga Kost',
            'water_bill' => 'Pembayaran Air Bulanan',
            'electricity_bill' => 'Pembayaran Listrik Bulanan',
            'supplies' => 'Alat-alat Kost (Plastik Sampah, dll)',
            'gas' => 'Tabung Gas Dapur',
            'maintenance' => 'Renovasi / Perbaikan',
            'internet' => 'Internet / WiFi',
            'cleaning' => 'Kebersihan',
            'other' => 'Lainnya',
            default => $this->category,
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'staff_salary' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            'water_bill' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
            'electricity_bill' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
            'supplies' => 'bg-green-500/10 text-green-400 border-green-500/20',
            'gas' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
            'maintenance' => 'bg-red-500/10 text-red-400 border-red-500/20',
            'internet' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
            'cleaning' => 'bg-teal-500/10 text-teal-400 border-teal-500/20',
            default => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
        };
    }
}
