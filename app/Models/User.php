<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'password',
        'phone',
        'dob',
        'country',
        'fname',
        'delivery_address',
        'delivery_phone',
        'display_picture',
        'emailAddress',
        'currency',
        'account_type',
        'transaction_pin',
        'show_password',
        'account_number',
        'kin_full_name',
        'kin_relationship',
        'kin_phone',
        'kin_email',
        'kin_address',
        'referral_source',
        'eligible_loan',
        'withdrawal_code'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'transaction_pin',
        'show_password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'is_suspended'      => 'boolean',
        'is_on_hold'         => 'boolean',
        'is_frozen'          => 'boolean',
    ];

    public function accountRestrictionMessage(): ?string
    {
        if ($this->is_suspended) {
            return 'Your account is suspended. Please contact support.';
        }

        if ($this->is_on_hold) {
            return 'Your account is on hold. Please contact support.';
        }

        if ($this->is_frozen) {
            return 'Your account is frozen. Please contact support.';
        }

        return null;
    }


     public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

     public function debits()
    {
        return $this->hasMany(Debit::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function investPlans()
    {
        return $this->hasMany(InvestPlan::class);
    }

    public function investProfits()
    {
        return $this->hasMany(InvestProfit::class);
    }

    public function investDebitProfits()
    {
        return $this->hasMany(InvestDebitProfit::class);
    }

    public function investEarnings()
    {
        return $this->hasMany(InvestEarning::class);
    }

    public function investReferrals()
    {
        return $this->hasMany(InvestReferral::class);
    }

    public function investKycs()
    {
        return $this->hasMany(InvestKyc::class);
    }

    public function investNotifications()
    {
        return $this->hasMany(InvestNotification::class);
    }
}