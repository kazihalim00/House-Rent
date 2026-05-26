<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $fillable = [
        'house_name',
        'email',
        'phone',
        'address',
        'city',
        'division',
        'home_price',
        'home_image',

    ];
}
