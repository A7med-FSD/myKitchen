<?php

namespace Tests\Feature\Category;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyCategoryTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    // =========================================================================
    // 1) Basic delete
    // =========================================================================

    /** @test */
    public function owner_can_delete_an_empty_category(): void
    {
        $category = Category::create(['name' => 'Empty Category', 'emoji' => '📦']);

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function it_returns_404_when_category_does_not_exist(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson('/api/categories/9999');

        $response->assertStatus(404);
    }

    // =========================================================================
    // 2) Business rule: لا يمكن حذف category عندها dishes
    // =========================================================================

    /** @test */
    public function owner_cannot_delete_a_category_that_has_dishes(): void
    {
        $category = Category::create(['name' => 'Has Dishes', 'emoji' => '🍽️']);

        Dish::create([
            'name'           => 'Test Dish',
            'description'    => 'A dish linked to this category',
            'price'          => 100,
            'category_id'    => $category->id,
            'time_preparing' => 15,
            'is_available'   => true,
            'image'          => 'test.jpg',
        ]);

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(422);

        // الـ category لازم تفضل موجودة
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    /** @test */
    public function owner_can_delete_a_category_after_its_dishes_are_removed(): void
    {
        $category = Category::create(['name' => 'Cleared Category', 'emoji' => '🗑️']);

        $dish = Dish::create([
            'name'           => 'Removable Dish',
            'description'    => 'Will be deleted',
            'price'          => 80,
            'category_id'    => $category->id,
            'time_preparing' => 10,
            'is_available'   => true,
            'image'          => 'removable.jpg',
        ]);

        // امسح الـ dish الأول
        $dish->delete();

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    // =========================================================================
    // 3) Authorization
    // =========================================================================

    /** @test */
    public function unauthenticated_user_cannot_delete_a_category(): void
    {
        $category = Category::create(['name' => 'Protected Category', 'emoji' => '🔒']);

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(401);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    /** @test */
    public function customer_cannot_delete_a_category(): void
    {
        $customer = User::factory()->create();
        $category = Category::create(['name' => 'Customer Target', 'emoji' => '🎯']);

        $response = $this->actingAs($customer, 'customer')
            ->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(401);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
