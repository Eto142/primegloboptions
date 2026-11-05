<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add investment broker columns to the users table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('first_name');
            }
            if (! Schema::hasColumn('users', 'lname')) {
                $table->string('lname')->nullable();
            }
            if (! Schema::hasColumn('users', 'signal_strength')) {
                $table->integer('signal_strength')->default(50);
            }
            if (! Schema::hasColumn('users', 'kyc_status')) {
                $table->string('kyc_status')->default('0');
            }
            if (! Schema::hasColumn('users', 'bot_status')) {
                $table->string('bot_status')->default('0');
            }
            if (! Schema::hasColumn('users', 'bot_image')) {
                $table->string('bot_image')->nullable();
            }
            if (! Schema::hasColumn('users', 'id_card')) {
                $table->string('id_card')->nullable();
            }
            if (! Schema::hasColumn('users', 'passport')) {
                $table->string('passport')->nullable();
            }
            if (! Schema::hasColumn('users', 'update_notification')) {
                $table->text('update_notification')->nullable();
            }
            if (! Schema::hasColumn('users', 'update_escrow')) {
                $table->decimal('update_escrow', 15, 2)->default(0);
            }
            // withdrawal_code already exists in the users table from the
            // initial migration, so only add it when it is missing.
            if (! Schema::hasColumn('users', 'withdrawal_code')) {
                $table->string('withdrawal_code')->nullable();
            }
            if (! Schema::hasColumn('users', 'withdrawal_tax_code')) {
                $table->string('withdrawal_tax_code')->nullable();
            }
            if (! Schema::hasColumn('users', 'withdrawal_amount')) {
                $table->decimal('withdrawal_amount', 15, 2)->default(0);
            }
            if (! Schema::hasColumn('users', 'withdrawal_tax_amount')) {
                $table->decimal('withdrawal_tax_amount', 15, 2)->default(0);
            }
            if (! Schema::hasColumn('users', 'withdrawal_percentage')) {
                $table->decimal('withdrawal_percentage', 5, 2)->default(0);
            }
            if (! Schema::hasColumn('users', 'show_kyc_notice')) {
                $table->boolean('show_kyc_notice')->default(1);
            }
            if (! Schema::hasColumn('users', 'show_signal_strength')) {
                $table->boolean('show_signal_strength')->default(1);
            }
            if (! Schema::hasColumn('users', 'profit_limit_status')) {
                $table->boolean('profit_limit_status')->default(0);
            }
            if (! Schema::hasColumn('users', 'user_status')) {
                $table->string('user_status')->default('1');
            }
            if (! Schema::hasColumn('users', 'usertype')) {
                $table->string('usertype')->default('0');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'name',
                'lname',
                'signal_strength',
                'kyc_status',
                'bot_status',
                'bot_image',
                'id_card',
                'passport',
                'update_notification',
                'update_escrow',
                'withdrawal_code',
                'withdrawal_tax_code',
                'withdrawal_amount',
                'withdrawal_tax_amount',
                'withdrawal_percentage',
                'show_kyc_notice',
                'show_signal_strength',
                'profit_limit_status',
                'user_status',
                'usertype',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
