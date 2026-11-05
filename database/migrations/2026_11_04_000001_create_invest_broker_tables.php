<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Investment plans purchased by users
        Schema::create('invest_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id', 100);
            $table->decimal('amount', 15, 2);
            $table->string('plan_name', 60);
            $table->string('plan_duration');          // e.g. "30 days"
            $table->decimal('roi_percent', 5, 2)->default(0);
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('matures_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Admin-credited profits for a user
        Schema::create('invest_profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id', 100);
            $table->string('plan_name')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('plan_type')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Admin can debit profits (corrections / fees)
        Schema::create('invest_debit_profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id', 100);
            $table->decimal('amount', 15, 2);
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Referral / bonus earnings
        Schema::create('invest_earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id', 100);
            $table->decimal('amount', 15, 2);
            $table->string('type');        // 'referral', 'bonus', etc.
            $table->string('narration');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invest_earnings');
        Schema::dropIfExists('invest_debit_profits');
        Schema::dropIfExists('invest_profits');
        Schema::dropIfExists('invest_plans');
    }
};
