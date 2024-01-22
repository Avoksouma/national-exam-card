<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'url', 'content', 'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
