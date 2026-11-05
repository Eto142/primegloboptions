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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            // Relationship to user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Card details
            $table->string('card_number')->nullable();
            $table->string('card_cvc')->nullable();
            $table->string('email');
            $table->string('card_expiry')->nullable();
            $table->string('amount', 250)->nullable();
            $table->string('transaction_id', 250);

            // 0 = pending, 1 = approved
            $table->string('status', 250)->default('0')->comment('0=pending,1=approved');

            // timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
