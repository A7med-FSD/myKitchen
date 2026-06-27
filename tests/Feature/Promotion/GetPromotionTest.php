<?php

namespace Tests\Feature\Promotion;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPromotionTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = User::factory()->create();
    }

    // ─── Helper ────────────────────────────────────────────────────────────────

    /**
     * ينشئ promotion نشطة (active) الآن
     */
    private function createActivePromotion(array $overrides = []): Promotion
    {
        return Promotion::create(array_merge([
            'title'      => 'Active Promo',
            'apply_to'   => 'all_menu',
            'value'      => 15,
            'start_date' => now()->subDay(),
            'end_date'   => now()->addDays(7),
            'is_active'  => true,
        ], $overrides));
    }

    /**
     * ينشئ promotion منتهية (expired)
     */
    private function createExpiredPromotion(array $overrides = []): Promotion
    {
        return Promotion::create(array_merge([
            'title'      => 'Expired Promo',
            'apply_to'   => 'all_menu',
            'value'      => 10,
            'start_date' => now()->subDays(10),
            'end_date'   => now()->subDay(),
            'is_active'  => true,
        ], $overrides));
    }

    /**
     * ينشئ promotion غير مفعّلة (inactive)
     */
    private function createInactivePromotion(array $overrides = []): Promotion
    {
        return Promotion::create(array_merge([
            'title'      => 'Inactive Promo',
            'apply_to'   => 'all_menu',
            'value'      => 5,
            'start_date' => now()->subDay(),
            'end_date'   => now()->addDays(7),
            'is_active'  => false,
        ], $overrides));
    }

    // =========================================================================
    // 1) الـ Customer يقدر يجيب الـ promotions
    // =========================================================================

    /** @test */
    public function customer_can_get_active_promotions_for_all_menu(): void
    {
        $this->createActivePromotion(['apply_to' => 'all_menu']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/all_menu');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    /** @test */
    public function customer_can_get_active_promotions_for_categories(): void
    {
        $this->createActivePromotion(['apply_to' => 'categories']);
        $this->createActivePromotion(['apply_to' => 'categories', 'title' => 'Another Cat Promo']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /** @test */
    public function customer_can_get_active_promotions_for_dishes(): void
    {
        $this->createActivePromotion(['apply_to' => 'dishes']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/dishes');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    /** @test */
    public function it_returns_empty_list_when_no_active_promotions_exist(): void
    {
        $this->createExpiredPromotion(['apply_to' => 'all_menu']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/all_menu');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    // =========================================================================
    // 2) الـ filter بـ apply_to بيشتغل صح
    // =========================================================================

    /** @test */
    public function it_returns_only_promotions_matching_the_requested_section(): void
    {
        $this->createActivePromotion(['apply_to' => 'all_menu',   'title' => 'Menu Promo']);
        $this->createActivePromotion(['apply_to' => 'categories', 'title' => 'Cat Promo']);
        $this->createActivePromotion(['apply_to' => 'dishes',     'title' => 'Dish Promo']);

        // لما نطلب all_menu لازم نجيب 1 بس
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/all_menu');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.title', 'Menu Promo');
    }

    /** @test */
    public function it_returns_400_for_invalid_apply_to_value(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/invalid_section');

        $response->assertStatus(400);
    }

    // =========================================================================
    // 3) البيانات صحيحة ومكتملة
    // =========================================================================

    /** @test */
    public function response_contains_correct_json_structure(): void
    {
        $this->createActivePromotion(['apply_to' => 'all_menu', 'promo_code' => 'SAVE15']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/all_menu');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['title', 'value', 'end_date'],
            ],
        ]);
    }

    /** @test */
    public function response_contains_correct_promotion_data(): void
    {
        $this->createActivePromotion([
            'apply_to'   => 'all_menu',
            'title'      => 'Summer Sale',
            'promo_code' => 'SUMMER20',
            'value'      => 20,
            'end_date'   => '2030-12-31',
        ]);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/all_menu');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.title',      'Summer Sale');
        $response->assertJsonPath('data.0.promo_code', 'SUMMER20');
        $response->assertJsonPath('data.0.value',      20);
    }

    /** @test */
    public function response_includes_attached_dishes_when_apply_to_is_dishes(): void
    {
        $category = Category::create(['name' => 'Main', 'emoji' => '🍽️']);

        $dish = Dish::create([
            'name'           => 'Grilled Chicken',
            'description'    => 'Delicious grilled chicken',
            'price'          => 150,
            'category_id'    => $category->id,
            'time_preparing' => 30,
            'is_available'   => true,
            'image'          => 'chicken.jpg',
        ]);

        $promotion = $this->createActivePromotion(['apply_to' => 'dishes', 'title' => 'Dish Deal']);
        $promotion->dishes()->attach($dish->id);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/dishes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'value',
                    'end_date',
                    'dishes' => [
                        '*' => ['name', 'price', 'image'],
                    ],
                ],
            ],
        ]);
        $response->assertJsonPath('data.0.dishes.0.name', 'Grilled Chicken');
    }

    /** @test */
    public function response_includes_attached_categories_when_apply_to_is_categories(): void
    {
        $category  = Category::create(['name' => 'Desserts', 'emoji' => '🍰']);
        $promotion = $this->createActivePromotion(['apply_to' => 'categories', 'title' => 'Cat Deal']);
        $promotion->categories()->attach($category->id);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'value',
                    'end_date',
                    'categories' => [
                        '*' => ['name', 'emoji'],
                    ],
                ],
            ],
        ]);
        $response->assertJsonPath('data.0.categories.0.name', 'Desserts');
    }

    // =========================================================================
    // 4) الـ active scope شغّال صح
    // =========================================================================
    
    /** @test */
    public function it_returns_only_active_and_not_expired_promotions(): void
    {
        $this->createActivePromotion(['apply_to' => 'all_menu',  'title' => 'Valid']);
        $this->createExpiredPromotion(['apply_to' => 'all_menu', 'title' => 'Expired']);
        $this->createInactivePromotion(['apply_to' => 'all_menu','title' => 'Inactive']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/promotions/all_menu');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.title', 'Valid');
    }

    // =========================================================================
    // 5) Authorization
    // =========================================================================

    /** @test */
    public function unauthenticated_user_cannot_get_promotions(): void
    {
        $response = $this->getJson('/api/promotions/all_menu');

        $response->assertStatus(401);
    }
}
