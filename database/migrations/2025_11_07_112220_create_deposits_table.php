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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();

            // Relationship
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Deposit details
            $table->string('deposit_type')->nullable(); // e.g., bank, crypto, cheque
            $table->string('transaction_id')->nullable();

            // Cheque image uploads
            $table->string('front_cheque')->nullable(); // path to image
            $table->string('back_cheque')->nullable();  // path to image

            // Amount and user email
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('email')->nullable();

            // Deposit status (0 = pending, 1 = approved)
            $table->boolean('status')->default(0);

            // Timestamps
            $table->timestamps();

            // Optional soft deletes (for safe record removal)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
