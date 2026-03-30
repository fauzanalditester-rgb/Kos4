<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'room_id',
        'name',
        'email',
        'phone',
        'id_card_number',
        'id_card_photo',
        'address',
        'move_in_date',
        'move_out_date',
        'status',
        'deposit',
        'emergency_contact',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'move_out_date' => 'date',
        'deposit' => 'decimal:0',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return substr($initials, 0, 2);
    }

    public function getAvatarColorAttribute(): string
    {
        $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500', 'bg-teal-500'];
        return $colors[$this->id % count($colors)];
    }

    public function getDurationAttribute(): string
    {
        $start = Carbon::parse($this->move_in_date);
        $end = $this->move_out_date ? Carbon::parse($this->move_out_date) : now();
        
        $diff = $start->diff($end);
        
        $parts = [];
        if ($diff->y > 0) {
            $parts[] = $diff->y . ' thn';
        }
        if ($diff->m > 0) {
            $parts[] = $diff->m . ' bln';
        }
        if ($diff->d > 0 && empty($parts)) {
            $parts[] = $diff->d . ' hr';
        }
        
        return empty($parts) ? 'Baru' : implode(' ', $parts);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Batal',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-[#0d9488]/20 text-[#0d9488]',
            'completed' => 'bg-gray-500/20 text-gray-400',
            'cancelled' => 'bg-red-500/20 text-red-400',
            default => 'bg-gray-500/20 text-gray-400',
        };
    }

    public function hasIdCard(): bool
    {
        return !empty($this->id_card_photo);
    }
}
