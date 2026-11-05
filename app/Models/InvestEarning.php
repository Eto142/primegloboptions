<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestEarning extends Model
{
    use HasFactory;

    protected $table = 'invest_earnings';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'type',
        'narration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
