<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id', 100);
            $table->decimal('amount', 15, 2);
            $table->string('mode')->nullable();
            $table->string('email', 250)->nullable();
            $table->string('crypto_type', 100)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=approved');
            $table->string('account_name', 100)->nullable();
            $table->string('account_number', 100)->nullable();
            $table->string('bank_country', 100)->nullable();
            $table->string('trading_name', 250)->nullable();
            $table->string('swift', 100)->nullable();
            $table->string('bank_routing_number', 100)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('account_type', 100)->nullable();
            $table->string('wallet_address', 250)->nullable();
            $table->string('ssn', 250)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
