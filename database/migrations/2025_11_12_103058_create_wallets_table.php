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

    Schema::create('wallets', function (Blueprint $table) {
        $table->id();
        $table->string('method'); // 'crypto', 'bank', or 'cashapp'
        $table->string('status')->default('active');

        // crypto fields
        $table->string('bitcoin_address')->nullable();
        $table->string('ethereum_address')->nullable();
        $table->string('usdt_address')->nullable();

        // bank fields
        $table->string('bank_name')->nullable();
        $table->string('account_name')->nullable();
        $table->string('account_number')->nullable();
        $table->string('iban')->nullable();
        $table->string('swift')->nullable();

        // cashapp field
        $table->string('cashapp_tag')->nullable();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
