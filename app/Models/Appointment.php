<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'user_id',
        'visit_date',
        'visit_time',
        'message',
        'status',
    ];

    public function house()
    {
        return $this->belongsTo(Home::class, 'house_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}