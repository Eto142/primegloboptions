<?php

namespace Tests\Feature;

use App\Models\SavingsGoal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SavingsGoalTest extends TestCase
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

        Schema::create('savings_goals', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->decimal('target_amount', 15, 2);
            $table->decimal('saved_amount', 15, 2)->default(0);
            $table->date('target_date')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('savings_goals');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_user_can_create_a_savings_goal(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post(route('user.savings-goals.store'), [
                'name' => 'Emergency fund',
                'target_amount' => '1000.00',
            ])
            ->assertRedirect(route('user.savings-goals.index'));

        $this->assertDatabaseHas('savings_goals', [
            'user_id' => $user->id,
            'name' => 'Emergency fund',
            'target_amount' => '1000.00',
            'saved_amount' => '0.00',
        ]);
    }

    public function test_user_can_add_progress_without_exceeding_the_goal(): void
    {
        $user = $this->createUser();
        $goal = $this->createGoal($user, '100.00', '70.00');

        $this->actingAs($user)
            ->post(route('user.savings-goals.contributions.store', $goal), ['amount' => '30.00'])
            ->assertRedirect(route('user.savings-goals.index'));

        $this->assertSame('100.00', $goal->fresh()->saved_amount);
    }

    public function test_contribution_cannot_exceed_remaining_goal_amount(): void
    {
        $user = $this->createUser();
        $goal = $this->createGoal($user, '100.00', '70.00');

        $this->actingAs($user)
            ->from(route('user.savings-goals.index'))
            ->post(route('user.savings-goals.contributions.store', $goal), ['amount' => '30.01'])
            ->assertSessionHasErrors('amount');

        $this->assertSame('70.00', $goal->fresh()->saved_amount);
    }

    public function test_user_cannot_contribute_to_another_users_goal(): void
    {
        $owner = $this->createUser();
        $otherUser = $this->createUser();
        $goal = $this->createGoal($owner, '100.00', '0.00');

        $this->actingAs($otherUser)
            ->post(route('user.savings-goals.contributions.store', $goal), ['amount' => '10.00'])
            ->assertNotFound();

        $this->assertSame('0.00', $goal->fresh()->saved_amount);
    }

    private function createUser(): User
    {
        return User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'currency' => '$',
        ]);
    }

    private function createGoal(User $user, string $targetAmount, string $savedAmount): SavingsGoal
    {
        return SavingsGoal::create([
            'user_id' => $user->id,
            'name' => 'Test goal',
            'target_amount' => $targetAmount,
            'saved_amount' => $savedAmount,
        ]);
    }
}
