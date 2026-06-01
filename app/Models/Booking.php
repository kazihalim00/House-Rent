<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'house_id', 'guest_name', 'guest_email', 'guest_phone', 'check_in_date', 'booking_duration'
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(Home::class, 'house_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
