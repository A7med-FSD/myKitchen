<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // Customer logout
    // =========================================================================

    /** @test */
    public function customer_can_logout_successfully(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('web-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/logout');

        $response->assertStatus(204);
    }

    /** @test */
    public function customer_token_is_deleted_after_logout(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('web-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/logout');

        // التوكن المفروض اتمسح من الـ database
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    /** @test */
    public function customer_cannot_use_token_after_logout(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('web-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/logout');

        auth()->forgetUser();

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/user/profile');

        $response->assertStatus(401);
    }

    /** @test */
    public function unauthenticated_customer_cannot_logout(): void
    {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    }

    /** @test */
    public function customer_logout_only_deletes_current_token_not_all_tokens(): void
    {
        $user   = User::factory()->create();
        $token1 = $user->createToken('device-1')->plainTextToken;
        $token2 = $user->createToken('device-2')->plainTextToken;

        // لاوت بالتوكن الأول بس
        $this->withHeader('Authorization', "Bearer {$token1}")
            ->postJson('/api/auth/logout');

        // التوكن التاني المفروض يفضل شغّال
        $this->assertDatabaseCount('personal_access_tokens', 1);
        $response = $this->withHeader('Authorization', "Bearer {$token2}")
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
    }

    // =========================================================================
    // Owner logout
    // =========================================================================

    /** @test */
    public function owner_can_logout_successfully(): void
    {
        $admin = Admin::factory()->create();
        $token = $admin->createToken('web-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/owner/logout');

        $response->assertStatus(204);
    }

    /** @test */
    public function owner_token_is_deleted_after_logout(): void
    {
        $admin = Admin::factory()->create();
        $token = $admin->createToken('web-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/owner/logout');

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    /** @test */
    public function unauthenticated_owner_cannot_logout(): void
    {
        $response = $this->postJson('/api/auth/owner/logout');

        $response->assertStatus(401);
    }

    /** @test */
    public function customer_token_cannot_be_used_on_owner_logout_route(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('web-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/owner/logout');

        $response->assertStatus(401);
    }

    /** @test */
    public function owner_cannot_use_token_after_logout(): void
    {
        $user  = Admin::factory()->create();
        $token = $user->createToken('web-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/owner/logout');

        auth()->forgetUser();

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/ingredients');

        $response->assertStatus(401);
    }
}
