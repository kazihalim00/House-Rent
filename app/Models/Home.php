<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Home extends Model
{
    protected $table = 'homes';

    protected $fillable = [
        'house_name',
        'owner_name',
        'email',
        'phone',
        'address',
        'city',
        'division',
        'home_price',
        'bed',
        'bath',
        'about',
        'booking_date',
        'home_image',
        'status',
        'user_id',

    ];

    // a house can have multiple bookings and reviews, and belongs to a user (owner)
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'house_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'house_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
