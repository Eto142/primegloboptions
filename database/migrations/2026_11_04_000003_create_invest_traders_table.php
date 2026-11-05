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
        Schema::create('invest_traders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('image', 255)->nullable();
            $table->integer('copier')->default(0);
            $table->decimal('profit_share', 5, 2);
            $table->decimal('win_rate', 5, 2);
            $table->decimal('gains', 15, 2)->default(0);
            $table->string('risk', 20)->nullable();
            $table->decimal('loss', 15, 2)->default(0);
            $table->decimal('commission', 15, 2)->default(0);
            $table->integer('total_transactions')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_traders');
    }
};
