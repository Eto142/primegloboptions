<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
     protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'sender_name',
        'sender_account',
        'transaction_id',
        'transaction_ref',
        'transaction_type',
        'transaction',
        'transaction_amount',
        'transaction_description',
        'transaction_status',
        'wallet_type',
        'wallet_address',
        'credit',
        'debit',
    ];

    /**
     * Relationship: A transaction belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBankSide(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->whereNull('transaction')
                ->orWhere('transaction', '!=', 'Investment Deposit');
        });
    }
}
