<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'nationality',
        'contact_person',
        'contact_details',
        'image',
        'description',
        'dob',
        'father',
        'mother',
        'approved',
        'city',
        'user_id',
        'school_id',
        'combination_id'
    ];


    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }


    public function combination(): BelongsTo
    {
        return $this->belongsTo(Combination::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
