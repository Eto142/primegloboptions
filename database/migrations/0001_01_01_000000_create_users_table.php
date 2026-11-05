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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            
            // Additional fields for banking registration
            $table->string('phone');
            $table->string('dob');
            $table->string('country');
            $table->string('currency');
            $table->string('account_type');
            $table->string('transaction_pin');
            $table->string('show_password');
            $table->string('eligible_loan')->nullable();
            $table->string('fname')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_phone')->nullable(); 
            $table->string('emailAddress')->nullable();
            $table->string('display_picture')->nullable(); 
            $table->string('account_number')->unique();
            
            // Next of Kin fields
            $table->string('kin_full_name');
            $table->string('kin_relationship');
            $table->string('kin_phone');
            $table->string('kin_email')->nullable();
             $table->string('withdrawal_code')->nullable();
             $table->string('payment_status')->nullable();
            $table->text('kin_address');
            
            // Optional referral source
            $table->string('referral_source')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};