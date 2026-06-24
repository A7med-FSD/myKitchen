<?php

namespace Tests\Feature\Category;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    // =========================================================================
    // 1) Basic store
    // =========================================================================

    /** @test */
    public function owner_can_create_a_category(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/categories', [
                'name'  => 'Main Course',
                'emoji' => '🍽️',
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name' => 'Main Course']);
    }

    // =========================================================================
    // 2) Validation
    // =========================================================================

    /** @test */
    public function store_fails_when_name_is_missing(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/categories', [
                'emoji' => '🍰',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function store_fails_when_name_is_already_taken(): void
    {
        \App\Models\Category::create(['name' => 'Desserts', 'emoji' => '🍰']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/categories', [
                'name' => 'Desserts',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function store_fails_when_name_is_too_short(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/categories', [
                'name' => 'AB',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    // =========================================================================
    // 3) Authorization
    // =========================================================================

    /** @test */
    public function unauthenticated_user_cannot_create_a_category(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Unauthorized Category',
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('categories', ['name' => 'Unauthorized Category']);
    }

    /** @test */
    public function customer_cannot_create_a_category(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer, 'customer')
            ->postJson('/api/categories', [
                'name' => 'Customer Category',
            ]);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('categories', ['name' => 'Customer Category']);
    }
}
