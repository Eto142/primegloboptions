<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminLoanEligibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('first_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('eligible_loan')->nullable();
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table): void {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('debits', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_type');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('debits');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_updating_loan_eligibility_does_not_debit_the_user(): void
    {
        $admin = Admin::create([
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
        $user = User::create([
            'first_name' => 'Test',
            'email' => 'user@example.com',
            'password' => 'password',
            'eligible_loan' => '100.00',
        ]);

        $this->actingAs($admin, 'admin')
            ->from('/admin/profile/' . $user->id)
            ->post(route('admin.loan-eligibility.update', $user->id), [
                'amount' => '2500.50',
            ])
            ->assertRedirect('/admin/profile/' . $user->id)
            ->assertSessionHas('status');

        $this->assertSame('2500.50', $user->fresh()->eligible_loan);
        $this->assertDatabaseCount('debits', 0);
        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_loan_eligibility_cannot_be_negative(): void
    {
        $admin = Admin::create([
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
        $user = User::create([
            'first_name' => 'Test',
            'email' => 'user@example.com',
            'password' => 'password',
            'eligible_loan' => '100.00',
        ]);

        $this->actingAs($admin, 'admin')
            ->from('/admin/profile/' . $user->id)
            ->post(route('admin.loan-eligibility.update', $user->id), [
                'amount' => '-1',
            ])
            ->assertRedirect('/admin/profile/' . $user->id)
            ->assertSessionHasErrors('amount');

        $this->assertSame('100.00', $user->fresh()->eligible_loan);
        $this->assertDatabaseCount('debits', 0);
        $this->assertDatabaseCount('transactions', 0);
    }
}
