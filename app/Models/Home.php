<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'house_id');
    }
}
