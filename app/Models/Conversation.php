<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['tenant_id', 'owner_id'];

    // The tenant (normal user)
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    // The owner/admin
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // All messages in this conversation
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}