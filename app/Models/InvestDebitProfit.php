<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestDebitProfit extends Model
{
    use HasFactory;

    protected $table = 'invest_debit_profits';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
