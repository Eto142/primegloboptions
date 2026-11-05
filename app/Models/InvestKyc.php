<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestKyc extends Model
{
    use HasFactory;

    protected $table = 'invest_kycs';

    protected $fillable = [
        'user_id',
        'idcard',
        'passport',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
