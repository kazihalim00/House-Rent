<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
