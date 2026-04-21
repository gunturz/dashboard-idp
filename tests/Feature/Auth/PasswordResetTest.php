<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\ResetPasswordLinkNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = $this->createUser();

        $this->post('/forgot-password', ['login' => $user->email]);

        Notification::assertSentTo($user, ResetPasswordLinkNotification::class);

        $this->assertDatabaseHas('password_resets', [
            'user_id' => $user->id,
            'email' => $user->email,
            'is_used' => false,
        ]);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = $this->createUser();

        $this->post('/forgot-password', ['login' => $user->username]);

        Notification::assertSentTo($user, ResetPasswordLinkNotification::class, function ($notification) use ($user) {
            $token = $this->extractTokenFromNotification($notification, $user);
            $response = $this->get('/reset-password/'.$token.'?email='.urlencode($user->email));

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = $this->createUser();

        $this->post('/forgot-password', ['login' => $user->email]);

        Notification::assertSentTo($user, ResetPasswordLinkNotification::class, function ($notification) use ($user) {
            $token = $this->extractTokenFromNotification($notification, $user);
            $response = $this->post('/reset-password', [
                'token' => $token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response
                ->assertSessionHasNoErrors()
                ->assertRedirect(route('login'));

            return true;
        });
    }

    private function createUser(): User
    {
        $companyId = DB::table('company')->insertGetId([
            'nama_company' => 'Test Company',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $departmentId = DB::table('department')->insertGetId([
            'company_id' => $companyId,
            'nama_department' => 'Test Department',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $positionId = DB::table('position')->insertGetId([
            'position_name' => 'Test Position',
            'grade_level' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $roleId = DB::table('role')->insertGetId([
            'role_name' => 'talent',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return User::create([
            'nama' => 'Test User',
            'username' => 'test.user.'.fake()->unique()->numerify('###'),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'company_id' => $companyId,
            'department_id' => $departmentId,
            'position_id' => $positionId,
            'role_id' => $roleId,
        ]);
    }

    private function extractTokenFromNotification(ResetPasswordLinkNotification $notification, User $user): string
    {
        $mailMessage = $notification->toMail($user);
        $actionUrl = $mailMessage->actionUrl;

        $path = parse_url($actionUrl, PHP_URL_PATH) ?? '';

        return basename($path);
    }
}
