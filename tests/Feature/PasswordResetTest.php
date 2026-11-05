<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table): void {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_forgot_password_page_is_linked_from_login(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('password.request'));

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Send password reset link');
    }

    public function test_existing_user_receives_a_password_reset_link(): void
    {
        Notification::fake();
        $user = $this->createUser();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_unknown_email_gets_the_same_confirmation_without_a_notification(): void
    {
        Notification::fake();

        $this->post(route('password.email'), ['email' => 'missing@example.com'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('status');

        Notification::assertNothingSent();
    }

    public function test_user_can_reset_password_with_a_valid_token(): void
    {
        Notification::fake();
        $user = $this->createUser();
        $this->post(route('password.email'), ['email' => $user->email]);

        $notification = Notification::sent($user, ResetPassword::class)->first();

        $this->get(route('password.reset', [
            'token' => $notification->token,
            'email' => $user->email,
        ]))
            ->assertOk()
            ->assertSee('name="token"', false)
            ->assertSee('value="' . $notification->token . '"', false);

        $this->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'NewSecurePassword123!',
            'password_confirmation' => 'NewSecurePassword123!',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertTrue(Hash::check('NewSecurePassword123!', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }

    public function test_invalid_token_does_not_change_password(): void
    {
        $user = $this->createUser();

        $this->from(route('password.reset', ['token' => 'invalid', 'email' => $user->email]))
            ->post(route('password.update'), [
                'token' => 'invalid',
                'email' => $user->email,
                'password' => 'NewSecurePassword123!',
                'password_confirmation' => 'NewSecurePassword123!',
            ])
            ->assertRedirect()
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('CurrentPassword123!', $user->fresh()->password));
    }

    private function createUser(): User
    {
        return User::create([
            'email' => 'customer@example.com',
            'password' => Hash::make('CurrentPassword123!'),
        ]);
    }
}
