<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // 1) Basic registration
    // =========================================================================

    /** @test */
    public function user_can_register_with_valid_data(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '01012345678',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name'  => 'Ahmed Ali',
            'phone' => '01012345678',
        ]);
    }

    /** @test */
    public function register_returns_a_token_on_success(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '01012345678',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(201);
        // الـ response لازم يحتوي على data و token
        $response->assertJsonStructure([
            'data' => [
                'user',
                'token',
            ],
        ]);
    }

    /** @test */
    public function Register_returns_a_valid_token_that_can_access_protected_routes(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '01012345678',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(201);
        $token = $response->json('data.token');
        $this->assertNotNull($token);

        // نتأكد إن الـ token شغّال فعلاً بنروح بيه على الـ profile endpoint
        $profileResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/user/profile');

        $profileResponse->assertStatus(200);
    }

    // =========================================================================
    // 2) Validation errors
    // =========================================================================

    /** @test */
    public function register_fails_when_phone_is_missing(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phone']);
    }

    /** @test */
    public function register_fails_with_invalid_egyptian_phone_number(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '12345678',   // مش رقم مصري صحيح
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phone']);
    }

    /** @test */
    public function register_fails_when_phone_is_already_taken(): void
    {
        User::factory()->create(['phone' => '01012345678']);

        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Another User',
            'phone'                 => '01012345678',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phone']);
    }

    /** @test */
    public function register_fails_when_password_confirmation_does_not_match(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '01012345678',
            'password'              => 'secret123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function register_fails_when_password_is_too_short(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '01012345678',
            'password'              => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    // =========================================================================
    // 3) Image handling
    // =========================================================================

    /** @test */
    public function user_can_register_with_a_profile_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('profile.jpg');

        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '01012345678',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'image'                 => $image,
        ]);

        $response->assertStatus(201);

        $user = User::where('phone', '01012345678')->first();
        $this->assertNotNull($user->image);
        Storage::disk('public')->assertExists('users/' . $user->image);
    }

    /** @test */
    public function register_fails_when_uploaded_file_is_not_an_image(): void
    {
        $file = UploadedFile::fake()->create('resume.pdf', 500, 'application/pdf');

        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Ahmed Ali',
            'phone'                 => '01012345678',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'image'                 => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }
}
