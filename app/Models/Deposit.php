<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Deposit extends Model
{
    use HasFactory;
 protected $table = 'deposits';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'email',
        'status',
        'front_cheque',
        'license',
    ];

    /**
     * Relationship: A deposit belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor for formatted amount (e.g., ₦5,000.00 or $1,000.00)
     */
    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount, 2);
    }

    /**
     * Accessor for human-readable status
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Approved';
            case 2:
                return 'Declined';
            default:
                return 'Unknown';
        }
    }
}
