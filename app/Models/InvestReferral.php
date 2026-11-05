<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestReferral extends Model
{
    use HasFactory;

    protected $table = 'invest_referrals';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
