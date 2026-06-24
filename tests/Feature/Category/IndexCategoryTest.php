<?php

namespace Tests\Feature\Category;

use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_get_all_categories(): void
    {
        $customer = User::factory()->create();
        Category::create(['name' => 'Main Course', 'emoji' => '🍽️']);
        Category::create(['name' => 'Desserts',    'emoji' => '🍰']);

        $response = $this->actingAs($customer, 'customer')
            ->getJson('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /** @test */
    public function owner_can_get_all_categories(): void
    {
        $admin = Admin::factory()->create();
        Category::create(['name' => 'Starters', 'emoji' => '🥗']);

        $response = $this->actingAs($admin, 'owner')
            ->getJson('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    /** @test */
    public function it_returns_correct_json_structure(): void
    {
        $customer = User::factory()->create();
        Category::create(['name' => 'Drinks', 'emoji' => '🥤']);

        $response = $this->actingAs($customer, 'customer')
            ->getJson('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'emoji'],
            ],
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_get_categories(): void
    {
        $response = $this->getJson('/api/categories');

        $response->assertStatus(401);
    }
}
