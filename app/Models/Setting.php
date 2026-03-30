<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'price_daily',
        'price_weekly',
        'whatsapp_number',
        'status',
        'room_description',
    ];
}
