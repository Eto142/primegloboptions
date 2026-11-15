<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'is_suspended')) {
                $table->boolean('is_suspended')->default(false);
            }
            if (! Schema::hasColumn('users', 'is_on_hold')) {
                $table->boolean('is_on_hold')->default(false);
            }
            if (! Schema::hasColumn('users', 'is_frozen')) {
                $table->boolean('is_frozen')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_suspended', 'is_on_hold', 'is_frozen']);
        });
    }
};
