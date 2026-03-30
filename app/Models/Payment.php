<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'invoice_id',
        'payment_date',
        'amount',
        'method',
        'reference_number',
        'proof_photo',
        'notes',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:0',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            'transfer' => 'Transfer',
            'e-wallet' => 'E-Wallet',
            'tunai' => 'Tunai',
            'debit' => 'Debit',
            'kredit' => 'Kredit',
            default => 'Unknown',
        };
    }

    public function getMethodColorAttribute(): string
    {
        return match($this->method) {
            'transfer' => 'bg-[#0d9488]/10 text-[#0d9488] border-[#0d9488]/20',
            'e-wallet' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
            'tunai' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
            'debit' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            'kredit' => 'bg-pink-500/10 text-pink-400 border-pink-500/20',
            default => 'bg-gray-500/10 text-gray-400',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-500/10 text-yellow-400',
            'verified' => 'bg-green-500/10 text-green-400',
            'rejected' => 'bg-red-500/10 text-red-400',
            default => 'bg-gray-500/10 text-gray-400',
        };
    }
}
