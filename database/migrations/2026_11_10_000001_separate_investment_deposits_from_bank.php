<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('transactions')
            ->where('transaction_description', 'like', 'Crypto deposit%')
            ->update(['transaction' => 'Investment Deposit']);

        DB::table('deposits')
            ->whereExists(function ($query) {
                $query->selectRaw('1')
                    ->from('transactions')
                    ->whereColumn('transactions.transaction_id', 'deposits.transaction_id')
                    ->whereColumn('transactions.user_id', 'deposits.user_id')
                    ->where('transactions.transaction_description', 'like', 'Crypto deposit%');
            })
            ->update(['deposit_type' => 'investment']);
    }

    public function down(): void
    {
        DB::table('transactions')
            ->where('transaction', 'Investment Deposit')
            ->where('transaction_description', 'like', 'Crypto deposit%')
            ->update(['transaction' => 'Deposit']);

        DB::table('deposits')
            ->whereExists(function ($query) {
                $query->selectRaw('1')
                    ->from('transactions')
                    ->whereColumn('transactions.transaction_id', 'deposits.transaction_id')
                    ->whereColumn('transactions.user_id', 'deposits.user_id')
                    ->where('transactions.transaction_description', 'like', 'Crypto deposit%');
            })
            ->where('deposit_type', 'investment')
            ->update(['deposit_type' => 'crypto']);
    }
};
