<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('transaction_id')->unique();
            $table->string('asset_symbol', 12);
            $table->string('asset_name');
            $table->enum('type', ['buy', 'sell']);
            $table->enum('order_type', ['market', 'limit', 'stop']);
            $table->decimal('amount_usd', 15, 2);
            $table->decimal('quantity', 15, 6);
            $table->decimal('limit_price', 15, 6)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
