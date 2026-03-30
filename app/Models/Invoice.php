<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'rent_amount',
        'additional_amount',
        'total_amount',
        'paid_amount',
        'description',
        'status',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'rent_amount' => 'decimal:0',
        'additional_amount' => 'decimal:0',
        'total_amount' => 'decimal:0',
        'paid_amount' => 'decimal:0',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'sent' => 'Terkirim',
            'paid' => 'Lunas',
            'overdue' => 'Jatuh Tempo',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
            'sent' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            'paid' => 'bg-green-500/10 text-green-400 border-green-500/20',
            'overdue' => 'bg-red-500/10 text-red-400 border-red-500/20',
            'cancelled' => 'bg-gray-600/10 text-gray-500 border-gray-600/20',
            default => 'bg-gray-500/10 text-gray-400',
        };
    }

    public function getRemainingAmountAttribute(): float
    {
        return $this->total_amount - $this->paid_amount;
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->status === 'paid';
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'sent' && $this->due_date < now();
    }
}
