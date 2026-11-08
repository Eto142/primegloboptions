<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminAccountStatusTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('first_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->boolean('is_suspended')->default(false);
            $table->boolean('is_on_hold')->default(false);
            $table->boolean('is_frozen')->default(false);
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Route::get('/account-status-probe', fn () => response('ok'))
            ->middleware(['auth', 'user']);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('admins');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_admin_can_set_and_clear_each_account_status(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::create([
            'first_name' => 'Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        foreach ([
            'suspended' => 'is_suspended',
            'on_hold' => 'is_on_hold',
            'frozen' => 'is_frozen',
        ] as $statusType => $column) {
            $this->actingAs($admin, 'admin')
                ->from('/admin/profile/' . $user->id)
                ->post(route('admin.user.account-status', $user), [
                    'status_type' => $statusType,
                    'status' => '1',
                ])
                ->assertRedirect('/admin/profile/' . $user->id)
                ->assertSessionHas('status');

            $this->assertDatabaseHas('users', ['id' => $user->id, $column => 1]);

            $this->post(route('admin.user.account-status', $user), [
                'status_type' => $statusType,
                'status' => '0',
            ]);

            $this->assertDatabaseHas('users', ['id' => $user->id, $column => 0]);
        }
    }

    public function test_restricted_users_cannot_log_in_or_continue_using_user_pages(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::create([
            'first_name' => 'Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->is_suspended = true;
        $user->save();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Your account is suspended. Please contact support.',
            ]);

        $this->assertGuest();

        $user->is_suspended = false;
        $user->is_on_hold = true;
        $user->save();

        $this->actingAs($admin, 'admin')->actingAs($user, 'web')
            ->get('/account-status-probe')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error', 'Your account is on hold. Please contact support.')
            ->assertGuest('web')
            ->assertAuthenticatedAs($admin, 'admin');

        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_invalid_account_status_updates_are_rejected(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::create([
            'first_name' => 'Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($admin, 'admin')
            ->from('/admin/profile/' . $user->id)
            ->post(route('admin.user.account-status', $user), [
                'status_type' => 'user_status',
                'status' => '1',
            ])
            ->assertRedirect('/admin/profile/' . $user->id)
            ->assertSessionHasErrors('status_type');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_suspended' => 0,
            'is_on_hold' => 0,
            'is_frozen' => 0,
        ]);
    }

    public function test_admin_logout_does_not_log_out_the_user_guard(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::create([
            'first_name' => 'Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($admin, 'admin')->actingAs($user, 'web')
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'))
            ->assertGuest('admin')
            ->assertAuthenticatedAs($user, 'web');
    }

    public function test_user_logout_does_not_log_out_the_admin_guard(): void
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user = User::create([
            'first_name' => 'Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($admin, 'admin')->actingAs($user, 'web')
            ->post(route('user.logout'))
            ->assertRedirect('/login')
            ->assertGuest('web')
            ->assertAuthenticatedAs($admin, 'admin');
    }
}
