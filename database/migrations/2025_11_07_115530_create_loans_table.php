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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            // Relationship to users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Loan core data
            $table->string('transaction_id', 100);
            $table->integer('amount');
            $table->string('email', 255);

            // Additional application details
            $table->string('reason', 500)->nullable();
            $table->string('license', 255)->nullable();
            $table->string('photoID', 255)->nullable();
            $table->string('selfie', 255)->nullable();
            $table->string('ssn', 100)->nullable();
            $table->string('credit_score', 255)->nullable();

            // Status: 0 = pending, 1 = approved
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=approved');

            // Auto timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
