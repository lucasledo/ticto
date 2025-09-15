<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_redirects_to_admin_dashboard()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'email'     => 'admin@example.com',
            'password'  => Hash::make($password),
        ]);

        $response = $this->post(route('login'), [
            'email'     => $user->email,
            'password'  => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_employee_can_login_and_redirects_to_employee_dashboard()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'email'     => 'employee@example.com',
            'password'  => Hash::make($password),
        ]);

        $response = $this->post(route('login'), [
            'email'     => $user->email,
            'password'  => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'email'     => 'someone@example.com',
            'password'  => Hash::make($password),
        ]);

        $response = $this->from(route('login'))->post(route('login'), [
            'email'     => $user->email,
            'password'  => 'wrongpassword',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
