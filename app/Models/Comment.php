<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'user_name',
        'text',
        'is_admin_reply',
        'reply_to_id',
    ];

    protected $casts = [
        'is_admin_reply' => 'boolean',
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'reply_to_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'reply_to_id');
    }
}
