<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'processing_time',
        'minimum_deposit',
        'transaction_fee',
        'daily_limit',
        'features',
        'deposit_instructions',
        'wallet_addresses',
        'bank_details',
        'cashapp_tag',
        'paypal_email',
        'icon_color',
    ];

    protected $casts = [
        'features' => 'array',
        'wallet_addresses' => 'array',
        'bank_details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active payment methods.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the display name for the payment method type
     */
    public function getTypeDisplayNameAttribute()
    {
        return match($this->type) {
            'crypto' => 'Cryptocurrency',
            'cashapp' => 'Cash App',
            'bank' => 'Bank Transfer',
            'paypal' => 'PayPal',
            'card' => 'Card Transfer',
            default => ucfirst($this->type)
        };
    }

    /**
     * Check if payment method is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}