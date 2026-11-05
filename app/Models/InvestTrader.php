<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestTrader extends Model
{
    use HasFactory;

    protected $table = 'invest_traders';

    protected $fillable = [
        'name',
        'image',
        'copier',
        'profit_share',
        'win_rate',
        'gains',
        'risk',
        'loss',
        'commission',
        'total_transactions',
    ];
}
