<?php

namespace Tests\Feature\Promotion;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorePromotionTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    /** بيانات أساسية صالحة للـ all_menu */
    private function basePayload(array $overrides = []): array
    {
        return array_merge([
            'title'      => 'Ramadan Sale',
            'apply_to'   => 'all_menu',
            'promo_code' => 'RAMADAN10',
            'value'      => 10,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date'   => now()->addDays(10)->format('Y-m-d'),
            'is_active'  => false,
        ], $overrides);
    }

    private function createCategory(): Category
    {
        return Category::create(['name' => 'Main Course', 'emoji' => '🍽️']);
    }

    private function createDish(int $categoryId): Dish
    {
        return Dish::create([
            'name'           => 'Grilled Chicken',
            'description'    => 'Delicious grilled chicken',
            'price'          => 150,
            'category_id'    => $categoryId,
            'time_preparing' => 30,
            'is_available'   => true,
            'image'          => 'chicken.jpg',
        ]);
    }

    // =========================================================================
    // 1) Basic store
    // =========================================================================

    /** @test */
    public function owner_can_create_a_promotion_for_all_menu(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload());

        $response->assertStatus(201);
        $this->assertDatabaseHas('promotions', ['title' => 'Ramadan Sale']);
    }

    /** @test */
    public function owner_can_create_a_promotion_for_special(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload([
                'title'      => 'Special Offer',
                'apply_to'   => 'special',
                'promo_code' => 'SPECIAL99',
            ]));

        $response->assertStatus(201);
        $this->assertDatabaseHas('promotions', [
            'title'    => 'Special Offer',
            'apply_to' => 'special',
        ]);
    }

    /** @test */
    public function promotion_is_stored_with_correct_values(): void
    {
        $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload([
                'title'      => 'Summer10',
                'value'      => 20,
                'promo_code' => 'SUMMER20',
                'is_active'  => true,
            ]));

        $this->assertDatabaseHas('promotions', [
            'title'      => 'Summer10',
            'value'      => 20,
            'promo_code' => 'SUMMER20',
            'is_active'  => true,
        ]);
    }

    // =========================================================================
    // 2) Authorization
    // =========================================================================

    /** @test */
    public function customer_cannot_create_a_promotion(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer, 'customer')
            ->postJson('/api/owner/promotions', $this->basePayload());

        $response->assertStatus(401);
        $this->assertDatabaseMissing('promotions', ['title' => 'Ramadan Sale']);
    }

    // =========================================================================
    // 3) apply_to = 'dishes': لازم dishes + بيتحفظ في الـ pivot
    // =========================================================================

    /** @test */
    public function owner_can_create_a_promotion_for_dishes_with_valid_dish_ids(): void
    {
        $category          = $this->createCategory();
        $dish              = $this->createDish($category->id);
        $payload           = $this->basePayload(['title' => 'Dish Promo', 'apply_to' => 'dishes']);
        $payload['dishes'] = [$dish->id];
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('promotions', ['title' => 'Dish Promo', 'apply_to' => 'dishes']);
    }

    /** @test */
    public function dish_promotion_is_saved_in_pivot_table(): void
    {
        $category  = $this->createCategory();
        $dishOne   = $this->createDish($category->id);
        $dishTwo   = Dish::create([
            'name' => 'Pasta', 'description' => 'Creamy pasta', 'price' => 120,
            'category_id' => $category->id, 'time_preparing' => 20,
            'is_available' => true, 'image' => 'pasta.jpg',
        ]);

        $payload           = $this->basePayload(['title' => 'Dishes Deal', 'apply_to' => 'dishes']);
        $payload['dishes'] = [$dishOne->id, $dishTwo->id];
        unset($payload['promo_code']);

        $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $promotion = \App\Models\Promotion::where('title', 'Dishes Deal')->first();

        $this->assertDatabaseHas('dish_promotion', [
            'promotion_id' => $promotion->id,
            'dish_id'      => $dishOne->id,
        ]);
        $this->assertDatabaseHas('dish_promotion', [
            'promotion_id' => $promotion->id,
            'dish_id'      => $dishTwo->id,
        ]);
    }

    /** @test */
    public function store_fails_when_apply_to_is_dishes_but_dishes_array_is_missing(): void
    {
        $payload = $this->basePayload(['title' => 'No Dishes', 'apply_to' => 'dishes']);
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['dishes']);
    }

    /** @test */
    public function store_fails_when_apply_to_is_dishes_but_dishes_array_is_empty(): void
    {
        $payload           = $this->basePayload(['title' => 'Empty Dishes', 'apply_to' => 'dishes']);
        $payload['dishes'] = [];
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['dishes']);
    }

    // =========================================================================
    // 4) apply_to = 'categories': لازم categories + بيتحفظ في الـ pivot
    // =========================================================================

    /** @test */
    public function owner_can_create_a_promotion_for_categories_with_valid_category_ids(): void
    {
        $category = $this->createCategory();

        $payload               = $this->basePayload(['title' => 'Cat Promo', 'apply_to' => 'categories']);
        $payload['categories'] = [$category->id];
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('promotions', ['title' => 'Cat Promo', 'apply_to' => 'categories']);
    }

    /** @test */
    public function category_promotion_is_saved_in_pivot_table(): void
    {
        $catOne = Category::create(['name' => 'Starters', 'emoji' => '🥗']);
        $catTwo = Category::create(['name' => 'Desserts', 'emoji' => '🍰']);

        $payload               = $this->basePayload(['title' => 'Cat Deal', 'apply_to' => 'categories']);
        $payload['categories'] = [$catOne->id, $catTwo->id];
        unset($payload['promo_code']);

        $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $promotion = \App\Models\Promotion::where('title', 'Cat Deal')->first();

        $this->assertDatabaseHas('category_promotion', [
            'promotion_id' => $promotion->id,
            'category_id'  => $catOne->id,
        ]);
        $this->assertDatabaseHas('category_promotion', [
            'promotion_id' => $promotion->id,
            'category_id'  => $catTwo->id,
        ]);
    }

    /** @test */
    public function store_fails_when_apply_to_is_categories_but_categories_array_is_missing(): void
    {
        $payload = $this->basePayload(['title' => 'No Cats', 'apply_to' => 'categories']);
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['categories']);
    }

    /** @test */
    public function store_fails_when_apply_to_is_categories_but_categories_array_is_empty(): void
    {
        $payload               = $this->basePayload(['title' => 'Empty Cats', 'apply_to' => 'categories']);
        $payload['categories'] = [];
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['categories']);
    }

    /** @test */
    public function store_fails_when_category_id_does_not_exist_in_database(): void
    {
        $payload               = $this->basePayload(['title' => 'Ghost Cat', 'apply_to' => 'categories']);
        $payload['categories'] = [99999];
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['categories.0']);
    }

    // =========================================================================
    // 5) promo_code مطلوب مع all_menu و special
    // =========================================================================

    /** @test */
    public function store_fails_when_apply_to_is_all_menu_and_promo_code_is_missing(): void
    {
        $payload = $this->basePayload(['apply_to' => 'all_menu']);
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['promo_code']);
    }

    /** @test */
    public function store_fails_when_apply_to_is_special_and_promo_code_is_missing(): void
    {
        $payload = $this->basePayload(['apply_to' => 'special']);
        unset($payload['promo_code']);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['promo_code']);
    }

    // =========================================================================
    // 6) General validation
    // =========================================================================

    /** @test */
    public function store_fails_when_required_fields_are_missing(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'apply_to', 'value', 'start_date', 'end_date']);
    }

    /** @test */
    public function store_fails_when_title_is_already_taken(): void
    {
        $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload(['title' => 'Duplicate']));

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload(['title' => 'Duplicate']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function store_fails_when_end_date_is_before_start_date(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload([
                'start_date' => now()->addDays(5)->format('Y-m-d'),
                'end_date'   => now()->addDays(2)->format('Y-m-d'),
            ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['end_date']);
    }

    /** @test */
    public function store_fails_when_apply_to_value_is_invalid(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload(['apply_to' => 'invalid_type']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['apply_to']);
    }

    /** @test */
    public function store_fails_when_value_exceeds_100(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/promotions', $this->basePayload(['value' => 101]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['value']);
    }
}
