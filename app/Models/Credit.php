<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'sender_name',
        'sender_account',
        'description',
        'created_at',
        'status',
    ];
}
