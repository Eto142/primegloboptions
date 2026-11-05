<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestProfit extends Model
{
    use HasFactory;

    protected $table = 'invest_profits';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'plan_name',
        'amount',
        'plan_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
