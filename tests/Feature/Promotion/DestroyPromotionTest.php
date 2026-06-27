<?php

namespace Tests\Feature\Promotion;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyPromotionTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    private function createPromotion(array $overrides = []): Promotion
    {
        return Promotion::create(array_merge([
            'title'      => 'Test Promo',
            'apply_to'   => 'all_menu',
            'promo_code' => 'CODE10',
            'value'      => 10,
            'start_date' => now()->addDay(),
            'end_date'   => now()->addDays(10),
            'is_active'  => false,
        ], $overrides));
    }

    private function createCategory(string $name = 'Main Course'): Category
    {
        return Category::create(['name' => $name, 'emoji' => '🍽️']);
    }

    private function createDish(int $categoryId, string $name = 'Grilled Chicken'): Dish
    {
        return Dish::create([
            'name'           => $name,
            'description'    => 'Test dish',
            'price'          => 100,
            'category_id'    => $categoryId,
            'time_preparing' => 20,
            'is_available'   => true,
            'image'          => 'test.jpg',
        ]);
    }

    // =========================================================================
    // 1) Basic delete
    // =========================================================================

    /** @test */
    public function owner_can_delete_an_all_menu_promotion(): void
    {
        $promotion = $this->createPromotion(['apply_to' => 'all_menu']);

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('promotions', ['id' => $promotion->id]);
    }

    /** @test */
    public function owner_can_delete_a_special_promotion(): void
    {
        $promotion = $this->createPromotion(['apply_to' => 'special', 'title' => 'Special Deal']);

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('promotions', ['id' => $promotion->id]);
    }

    /** @test */
    public function owner_cannot_delete_non_existent_promotion(): void 
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/9999");
        
        $response->assertStatus(404);
    }

    // =========================================================================
    // 2) Pivot cleanup: dishes
    // =========================================================================

    /** @test */
    public function deleting_a_dishes_promotion_removes_it_from_pivot_table(): void
    {
        $category  = $this->createCategory();
        $dish      = $this->createDish($category->id);
        $promotion = $this->createPromotion(['apply_to' => 'dishes', 'title' => 'Dish Promo']);
        $promotion->dishes()->attach($dish->id);

        $this->assertDatabaseHas('dish_promotion', ['promotion_id' => $promotion->id]);

        $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $this->assertDatabaseMissing('dish_promotion', ['promotion_id' => $promotion->id]);
        $this->assertDatabaseMissing('promotions', ['id' => $promotion->id]);
    }

    /** @test */
    public function deleting_a_dishes_promotion_does_not_delete_the_dishes_themselves(): void
    {
        $category  = $this->createCategory();
        $dish      = $this->createDish($category->id);
        $promotion = $this->createPromotion(['apply_to' => 'dishes', 'title' => 'Dish Promo 2']);
        $promotion->dishes()->attach($dish->id);

        $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        // الـ dish نفسه المفروض يفضل موجود
        $this->assertDatabaseHas('dishes', ['id' => $dish->id]);
    }

    /** @test */
    public function deleting_dishes_promotion_with_multiple_dishes_clears_all_pivot_entries(): void
    {
        $category  = $this->createCategory();
        $dishOne   = $this->createDish($category->id, 'Dish One');
        $dishTwo   = $this->createDish($category->id, 'Dish Two');
        $promotion = $this->createPromotion(['apply_to' => 'dishes', 'title' => 'Multi Dish Promo']);
        $promotion->dishes()->attach([$dishOne->id, $dishTwo->id]);

        $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $this->assertDatabaseMissing('dish_promotion', ['promotion_id' => $promotion->id, 'dish_id' => $dishOne->id]);
        $this->assertDatabaseMissing('dish_promotion', ['promotion_id' => $promotion->id, 'dish_id' => $dishTwo->id]);
    }

    // =========================================================================
    // 3) Pivot cleanup: categories
    // =========================================================================

    /** @test */
    public function deleting_a_categories_promotion_removes_it_from_pivot_table(): void
    {
        $category  = $this->createCategory();
        $promotion = $this->createPromotion(['apply_to' => 'categories', 'title' => 'Cat Promo']);
        $promotion->categories()->attach($category->id);

        $this->assertDatabaseHas('category_promotion', ['promotion_id' => $promotion->id]);

        $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $this->assertDatabaseMissing('category_promotion', ['promotion_id' => $promotion->id]);
        $this->assertDatabaseMissing('promotions', ['id' => $promotion->id]);
    }

    /** @test */
    public function deleting_a_categories_promotion_does_not_delete_the_categories_themselves(): void
    {
        $category  = $this->createCategory('Desserts');
        $promotion = $this->createPromotion(['apply_to' => 'categories', 'title' => 'Cat Promo 2']);
        $promotion->categories()->attach($category->id);

        $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    /** @test */
    public function deleting_categories_promotion_with_multiple_categories_clears_all_pivot_entries(): void
    {
        $catOne    = $this->createCategory('Starters');
        $catTwo    = $this->createCategory('Mains');
        $promotion = $this->createPromotion(['apply_to' => 'categories', 'title' => 'Multi Cat Promo']);
        $promotion->categories()->attach([$catOne->id, $catTwo->id]);

        $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $this->assertDatabaseMissing('category_promotion', ['promotion_id' => $promotion->id, 'category_id' => $catOne->id]);
        $this->assertDatabaseMissing('category_promotion', ['promotion_id' => $promotion->id, 'category_id' => $catTwo->id]);
    }

    // =========================================================================
    // 4) Authorization
    // =========================================================================
    
    /** @test */
    public function customer_cannot_delete_a_promotion(): void
    {
        $customer  = User::factory()->create();
        $promotion = $this->createPromotion();

        $response = $this->actingAs($customer, 'customer')
            ->deleteJson("/api/owner/promotions/{$promotion->id}");

        $response->assertStatus(401);
        $this->assertDatabaseHas('promotions', ['id' => $promotion->id]);
    }
}
