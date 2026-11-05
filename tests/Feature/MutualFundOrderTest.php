<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MutualFundOrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('currency');
            $table->timestamps();
        });

        Schema::create('trades', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id')->unique();
            $table->string('asset_symbol');
            $table->string('asset_name');
            $table->string('type');
            $table->string('order_type');
            $table->decimal('amount_usd', 15, 2);
            $table->decimal('quantity', 15, 6);
            $table->decimal('limit_price', 15, 6)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('trades');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_user_can_submit_a_mutual_fund_order_request(): void
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'currency' => '$',
        ]);

        $this->actingAs($user)
            ->post(route('user.investment.order'), [
                'asset_symbol' => 'USIDX',
                'type' => 'buy',
                'order_type' => 'market',
                'amount_usd' => '100.00',
                'quantity' => '1.000000',
            ])
            ->assertRedirect(route('user.mutual-funds'));

        $this->assertDatabaseHas('trades', [
            'user_id' => $user->id,
            'asset_symbol' => 'USIDX',
            'asset_name' => 'US Equity Index Fund',
            'type' => 'buy',
            'status' => 'pending',
        ]);
    }
}
