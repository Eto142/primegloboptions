<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestPlan extends Model
{
    use HasFactory;

    protected $table = 'invest_plans';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'plan_name',
        'plan_duration',
        'roi_percent',
        'status',
        'matures_at',
    ];

    protected $casts = [
        'matures_at' => 'datetime',
        'amount'     => 'decimal:2',
        'roi_percent'=> 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Projected return amount */
    public function getReturnAmountAttribute(): float
    {
        return round((float) $this->amount * ((float) $this->roi_percent / 100), 2);
    }

    /** Total payout at maturity */
    public function getMaturityValueAttribute(): float
    {
        return round((float) $this->amount + $this->return_amount, 2);
    }
}
