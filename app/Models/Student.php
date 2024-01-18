<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
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
        'user_id',
        'school_id'
    ];


    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
