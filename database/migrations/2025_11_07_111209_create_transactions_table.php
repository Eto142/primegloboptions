<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relationship to users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Core transaction info
            $table->string('transaction_id');
            $table->string('transaction_ref')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('transaction')->nullable();
            $table->string('email')->nullable();

            // Amounts and balances
            $table->decimal('credit', 15, 2)->nullable();
            $table->decimal('debit', 15, 2)->nullable();
            $table->decimal('transaction_amount', 15, 2)->nullable();

            // Wallet details
            $table->string('wallet_address')->nullable();
            $table->string('wallet_type')->nullable();

            // Description and status
            $table->text('transaction_description')->nullable();
            $table->string('transaction_status')->default('pending');

            // Branch and bank details
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();

            // Counterparty details (for transfers)
            $table->string('caccount_name')->nullable();
            $table->string('caccount_number')->nullable();
            $table->string('cbank_name')->nullable();

            // Bank and card details
            $table->string('bank_name')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('card_number')->nullable();
            $table->string('cvv')->nullable();
            $table->string('cdate')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
