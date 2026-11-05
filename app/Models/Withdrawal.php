<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $table = 'withdrawals';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'mode',
        'email',
        'crypto_type',
        'status',
        'account_name',
        'account_number',
        'bank_country',
        'trading_name',
        'swift',
        'bank_routing_number',
        'bank_name',
        'account_type',
        'wallet_address',
        'ssn',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
