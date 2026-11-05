<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->enum('type', ['crypto', 'cashapp', 'bank', 'paypal', 'card']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('processing_time');
            $table->string('minimum_deposit');
            $table->string('transaction_fee');
            $table->string('daily_limit');
            $table->json('features')->nullable();
            $table->text('deposit_instructions')->nullable();
            $table->json('wallet_addresses')->nullable();
            $table->json('bank_details')->nullable();
            $table->string('cashapp_tag')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('icon_color')->default('#0c7453');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}