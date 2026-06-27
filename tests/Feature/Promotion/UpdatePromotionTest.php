<?php

namespace Tests\Feature\Promotion;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePromotionTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    private function createGeneralPromotion(array $overrides = []): Promotion
    {
        return Promotion::create(array_merge([
            'title'      => 'General Promo',
            'apply_to'   => 'all_menu',
            'promo_code' => 'GENERAL10',
            'value'      => 10,
            'start_date' => now()->addDay(),
            'end_date'   => now()->addDays(10),
            'is_active'  => false,
        ], $overrides));
    }

    private function createSpecificPromotion(string $applyTo, array $overrides = []): Promotion
    {
        return Promotion::create(array_merge([
            'title'      => 'Specific Promo',
            'apply_to'   => $applyTo,
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
    // 1) Basic update (same apply_to — no relationship changes)
    // =========================================================================

    /** @test */
    public function owner_can_update_basic_fields_of_a_promotion(): void
    {
        $promotion = $this->createGeneralPromotion(['title' => 'Old Title']);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'title' => 'New Title',
                'value' => 20,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', [
            'id'    => $promotion->id,
            'title' => 'New Title',
            'value' => 20,
        ]);
    }

    /** @test */
    public function owner_can_toggle_is_active(): void
    {
        $promotion = $this->createGeneralPromotion(['is_active' => false]);

        $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", ['is_active' => true]);

        $this->assertDatabaseHas('promotions', ['id' => $promotion->id, 'is_active' => true]);
    }

    /** @test */
    public function owner_can_update_promo_code_when_apply_to_stays_general(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'all_menu', 'promo_code' => 'OLD10']);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'promo_code' => 'NEW20',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', ['id' => $promotion->id, 'promo_code' => 'NEW20']);
    }

    // =========================================================================
    // 2) Authorization
    // =========================================================================

    /** @test */
    public function customer_cannot_update_a_promotion(): void
    {
        $customer  = User::factory()->create();
        $promotion = $this->createGeneralPromotion();

        $response = $this->actingAs($customer, 'customer')
            ->patchJson("/api/owner/promotions/{$promotion->id}", ['title' => 'Hacked']);

        $response->assertStatus(401);
    }

    // =========================================================================
    // 3) General → Specific: الـ specific array مطلوب (required)
    // =========================================================================

    /** @test */
    public function changing_apply_to_from_general_to_dishes_requires_dishes_array(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'all_menu']);

        // بنحاول نغير لـ dishes من غير ما نبعت dishes array
        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'dishes',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['dishes']);
    }

    /** @test */
    public function changing_apply_to_from_general_to_dishes_fails_with_empty_array(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'all_menu']);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'dishes',
                'dishes'   => [],
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['dishes']);
    }

    /** @test */
    public function changing_apply_to_from_general_to_dishes_succeeds_with_valid_dish_ids(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'all_menu']);
        $category  = $this->createCategory();
        $dish      = $this->createDish($category->id);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'dishes',
                'dishes'   => [$dish->id],
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', ['id' => $promotion->id, 'apply_to' => 'dishes']);
        $this->assertDatabaseHas('dish_promotion', [
            'promotion_id' => $promotion->id,
            'dish_id'      => $dish->id,
        ]);
    }

    /** @test */
    public function changing_apply_to_from_special_to_categories_requires_categories_array(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'special']);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'categories',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['categories']);
    }

    /** @test */
    public function changing_apply_to_from_general_to_categories_succeeds_with_valid_category_ids(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'all_menu']);
        $category  = $this->createCategory();

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to'   => 'categories',
                'categories' => [$category->id],
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', ['id' => $promotion->id, 'apply_to' => 'categories']);
        $this->assertDatabaseHas('category_promotion', [
            'promotion_id' => $promotion->id,
            'category_id'  => $category->id,
        ]);
    }

    // =========================================================================
    // 4) Specific → General: الـ promo_code مطلوب (required)
    // =========================================================================

    /** @test */
    public function changing_apply_to_from_dishes_to_all_menu_requires_promo_code(): void
    {
        $promotion = $this->createSpecificPromotion('dishes');

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'all_menu',
                // لا promo_code
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['promo_code']);
    }

    /** @test */
    public function changing_apply_to_from_categories_to_special_requires_promo_code(): void
    {
        $promotion = $this->createSpecificPromotion('categories');

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'special',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['promo_code']);
    }

    /** @test */
    public function changing_apply_to_from_dishes_to_general_succeeds_with_promo_code(): void
    {
        $category  = $this->createCategory();
        $dish      = $this->createDish($category->id);
        $promotion = $this->createSpecificPromotion('dishes');
        $promotion->dishes()->attach($dish->id);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to'   => 'all_menu',
                'promo_code' => 'NEWCODE10',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', [
            'id'         => $promotion->id,
            'apply_to'   => 'all_menu',
            'promo_code' => 'NEWCODE10',
        ]);
    }

    /** @test */
    public function changing_from_dishes_to_general_detaches_old_dish_relations(): void
    {
        $category  = $this->createCategory();
        $dish      = $this->createDish($category->id);
        $promotion = $this->createSpecificPromotion('dishes');
        $promotion->dishes()->attach($dish->id);

        $this->assertDatabaseHas('dish_promotion', ['promotion_id' => $promotion->id]);

        $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to'   => 'all_menu',
                'promo_code' => 'DETACH99',
            ]);

        $this->assertDatabaseMissing('dish_promotion', ['promotion_id' => $promotion->id]);
    }

    /** @test */
    public function changing_from_categories_to_general_detaches_old_category_relations(): void
    {
        $category  = $this->createCategory();
        $promotion = $this->createSpecificPromotion('categories');
        $promotion->categories()->attach($category->id);

        $this->assertDatabaseHas('category_promotion', ['promotion_id' => $promotion->id]);

        $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to'   => 'special',
                'promo_code' => 'DETACH99',
            ]);

        $this->assertDatabaseMissing('category_promotion', ['promotion_id' => $promotion->id]);
    }

    // =========================================================================
    // 5) General → General: الـ promo_code optional (sometimes)
    // =========================================================================

    /** @test */
    public function changing_apply_to_from_all_menu_to_special_without_promo_code_succeeds(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'all_menu', 'promo_code' => 'OLD10']);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'special',
                // لا promo_code — المفروض يمشي لأنه sometimes
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', ['id' => $promotion->id, 'apply_to' => 'special']);
    }

    /** @test */
    public function changing_apply_to_from_all_menu_to_special_with_promo_code_updates_it(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'all_menu', 'promo_code' => 'OLD10']);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to'   => 'special',
                'promo_code' => 'NEWSPECIAL',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('promotions', [
            'id'         => $promotion->id,
            'apply_to'   => 'special',
            'promo_code' => 'NEWSPECIAL',
        ]);
    }

    /** @test */
    public function changing_apply_to_from_special_to_all_menu_without_promo_code_succeeds(): void
    {
        $promotion = $this->createGeneralPromotion(['apply_to' => 'special', 'promo_code' => 'SPEC10']);

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'all_menu',
            ]);

        $response->assertStatus(200);
    }

    // =========================================================================
    // 6) Specific → Specific: array الجديد مطلوب (required)
    // =========================================================================

    /** @test */
    public function changing_apply_to_from_dishes_to_categories_requires_categories_array(): void
    {
        $promotion = $this->createSpecificPromotion('dishes');

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'categories',
                // لا categories array
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['categories']);
    }

    /** @test */
    public function changing_apply_to_from_categories_to_dishes_requires_dishes_array(): void
    {
        $promotion = $this->createSpecificPromotion('categories');

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to' => 'dishes',
                // لا dishes array
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['dishes']);
    }

    /** @test */
    public function changing_apply_to_from_dishes_to_categories_detaches_dishes_and_attaches_categories(): void
    {
        $category  = $this->createCategory('Starters');
        $dish      = $this->createDish($category->id);
        $newCat    = $this->createCategory('Desserts');
        $promotion = $this->createSpecificPromotion('dishes');
        $promotion->dishes()->attach($dish->id);

        $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'apply_to'   => 'categories',
                'categories' => [$newCat->id],
            ]);

        // الـ dishes القديمة اتمسحت
        $this->assertDatabaseMissing('dish_promotion', ['promotion_id' => $promotion->id]);
        // الـ categories الجديدة اتحفظت
        $this->assertDatabaseHas('category_promotion', [
            'promotion_id' => $promotion->id,
            'category_id'  => $newCat->id,
        ]);
    }

    // =========================================================================
    // 7) Same apply_to (no change): relations تُعدَّل بـ sync لو اتبعتت
    // =========================================================================

    /** @test */
    public function updating_dishes_when_apply_to_stays_dishes_syncs_pivot(): void
    {
        $category = $this->createCategory();
        $oldDish  = $this->createDish($category->id, 'Old Dish');
        $newDish  = $this->createDish($category->id, 'New Dish');
        $promotion = $this->createSpecificPromotion('dishes');
        $promotion->dishes()->attach($oldDish->id);

        $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'dishes' => [$newDish->id],
            ]);

        // الـ old dish اتمسحت
        $this->assertDatabaseMissing('dish_promotion', [
            'promotion_id' => $promotion->id,
            'dish_id'      => $oldDish->id,
        ]);
        // الـ new dish اتحفظت
        $this->assertDatabaseHas('dish_promotion', [
            'promotion_id' => $promotion->id,
            'dish_id'      => $newDish->id,
        ]);
    }

    /** @test */
    public function updating_categories_when_apply_to_stays_categories_syncs_pivot(): void
    {
        $oldCat   = $this->createCategory('Old Cat');
        $newCat   = $this->createCategory('New Cat');
        $promotion = $this->createSpecificPromotion('categories');
        $promotion->categories()->attach($oldCat->id);

        $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/promotions/{$promotion->id}", [
                'categories' => [$newCat->id],
            ]);

        $this->assertDatabaseMissing('category_promotion', [
            'promotion_id' => $promotion->id,
            'category_id'  => $oldCat->id,
        ]);
        $this->assertDatabaseHas('category_promotion', [
            'promotion_id' => $promotion->id,
            'category_id'  => $newCat->id,
        ]);
    }
}
