<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // Customer Login (by phone or email)
    // =========================================================================

    /** @test */
    public function customer_can_login_with_phone(): void
    {
        $user = User::factory()->create([
            'phone'    => '01012345678',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->postJson('/api/auth/user/login', [
            'identifier' => '01012345678',
            'password'   => 'secret123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    /** @test */
    public function customer_can_login_with_email(): void
    {
        $user = User::factory()->create([
            'email'    => 'customer@test.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->postJson('/api/auth/user/login', [
            'identifier' => 'customer@test.com',
            'password'   => 'secret123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    /** @test */
    public function login_returns_a_valid_token_that_can_access_protected_routes(): void
    {
        User::factory()->create([
            'phone'    => '01012345678',
            'password' => Hash::make('secret123'),
        ]);

        $loginResponse = $this->postJson('/api/auth/user/login', [
            'identifier' => '01012345678',
            'password'   => 'secret123',
        ]);

        $loginResponse->assertStatus(200);
        $token = $loginResponse->json('data');
        $this->assertNotNull($token);

        // نتأكد إن الـ token شغّال فعلاً بنروح بيه على الـ profile endpoint
        $profileResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/user/profile');

        $profileResponse->assertStatus(200);
    }

    /** @test */
    public function customer_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'phone'    => '01012345678',
            'password' => Hash::make('correct_password'),
        ]);

        $response = $this->postJson('/api/auth/user/login', [
            'identifier' => '01012345678',
            'password'   => 'wrong_password',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function customer_login_fails_with_non_existent_identifier(): void
    {
        $response = $this->postJson('/api/auth/user/login', [
            'identifier' => '01099999999',
            'password'   => 'anypassword',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function login_returns_validation_error_when_identifier_is_missing(): void
    {
        $response = $this->postJson('/api/auth/user/login', [
            'password' => 'secret123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['identifier']);
    }

    /** @test */
    public function login_returns_validation_error_when_password_is_missing(): void
    {
        $response = $this->postJson('/api/auth/user/login', [
            'identifier' => '01012345678',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    // =========================================================================
    // Owner (Admin) Login
    // =========================================================================

    /** @test */
    public function owner_can_login_with_email(): void
    {
        Admin::factory()->create([
            'email'    => 'owner@kitchen.com',
            'password' => Hash::make('adminpass'),
        ]);

        $response = $this->postJson('/api/auth/owner/login', [
            'identifier' => 'owner@kitchen.com',
            'password'   => 'adminpass',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    /** @test */
    public function owner_login_fails_with_wrong_password(): void
    {
        Admin::factory()->create([
            'email'    => 'owner@kitchen.com',
            'password' => Hash::make('correct_pass'),
        ]);

        $response = $this->postJson('/api/auth/owner/login', [
            'identifier' => 'owner@kitchen.com',
            'password'   => 'wrong_pass',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function owner_login_fails_with_non_existent_email(): void
    {
        $response = $this->postJson('/api/auth/owner/login', [
            'identifier' => 'ghost@kitchen.com',
            'password'   => 'anypassword',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function customer_credentials_cannot_be_used_to_login_as_owner(): void
    {
        // Customer موجود بنفس الـ email
        User::factory()->create([
            'email'    => 'customer@kitchen.com',
            'password' => Hash::make('mypassword'),
        ]);

        // لو حد حاول يلوج بـ owner route بـ customer credentials
        $response = $this->postJson('/api/auth/owner/login', [
            'identifier' => 'customer@kitchen.com',
            'password'   => 'mypassword',
        ]);

        $response->assertStatus(401);
    }
}
