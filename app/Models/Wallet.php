<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'status',
        'bitcoin_address',
        'ethereum_address',
        'usdt_address',
        'bank_name',
        'account_name',
        'account_number',
        'iban',
        'swift',
        'cashapp_tag',
    ];
}
