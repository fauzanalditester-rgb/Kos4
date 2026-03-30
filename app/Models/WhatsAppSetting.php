<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key',
        'api_url',
        'device_id',
        'is_connected',
    ];

    protected $casts = [
        'is_connected' => 'boolean',
    ];
}
