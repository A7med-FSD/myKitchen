<?php

namespace Tests\Unit;

use App\Services\OrderService;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Promotion;
use App\Events\OrderDelivered;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class OrderTest extends TestCase
{
    private OrderService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OrderService();
    }

    // ═══════════════════════════════════════════════════════════════════
    //  calculateTotalPrice Tests
    // ═══════════════════════════════════════════════════════════════════

    private function makeDish(int $price, int $quantity, ?int $promotionValue): object
    {
        $pivot = (object) [
            'dish_price_at_order' => $price,
            'quantity'            => $quantity,
            'promotion_value'     => $promotionValue,
        ];

        $dish = (object) [
            'pivot'       => $pivot,
            'total_price' => 0,
        ];

        return $dish;
    }

    private function makeOrder(array $dishes, ?int $orderPromotionValue = null): object
    {
        $order = (object) [
            'dishes'          => $dishes,
            'promotion_value' => $orderPromotionValue,
            'total_price'     => 0,
        ];

        return $order;
    }

    // ─── Test 1: Multiple dishes, some with promotion ───────────────────
    public function test_calculate_total_price_multiple_dishes_mixed_promotions(): void
    {
        // Dish 1: price=85, qty=3, promo=20% → (85×0.8)×3 = 204
        // Dish 2: price=35, qty=1, promo=10% → (35×0.9)×1 = 31.5
        // Dish 3: price=50, qty=2, no promo  → 50×2 = 100
        // Total = 204 + 31.5 + 100 = 335.5
        $dish1 = $this->makeDish(50, 2, null);
        $dish2 = $this->makeDish(35, 1, 10);
        $dish3 = $this->makeDish(85, 3, 20);
        $order = $this->makeOrder([$dish1, $dish2, $dish3]);

        $this->service->calculateTotalPrice([$order]);

        $this->assertEquals(100,   $dish1->total_price);
        $this->assertEquals(31.5,  $dish2->total_price);
        $this->assertEquals(204,   $dish3->total_price);
        $this->assertEquals(335.5, $order->total_price);
    }

    // ─── Test 2: Order-level promotion applied on top of dish promotions ─
    public function test_calculate_total_price_with_order_promotion(): void
    {
        // Dish 1: price=85, qty=3, promo=20% → 204
        // Dish 2: price=35, qty=1, promo=10% → 31.5
        // Subtotal = 235.5
        // Order promo = 10% → 235.5 × 0.9 = 211.95
        $dish1 = $this->makeDish(85, 3, 20);
        $dish2 = $this->makeDish(35, 1, 10);
        $order = $this->makeOrder([$dish1, $dish2], 10);

        $this->service->calculateTotalPrice([$order]);

        $this->assertEquals(235.5, $order->total_price_before_promotion);
        $this->assertEquals(211.95, $order->total_price);
    }

    // ─── Test 3: Multiple orders in one call ────────────────────────────
    public function test_calculate_total_price_multiple_orders(): void
    {
        $dish1 = $this->makeDish(100, 1, null);  // → 100
        $order1 = $this->makeOrder([$dish1]);

        $dish2 = $this->makeDish(50, 2, 10);     // → (50×0.9)×2 = 90
        $order2 = $this->makeOrder([$dish2]);

        $this->service->calculateTotalPrice([$order1, $order2]);

        $this->assertEquals(100, $order1->total_price);
        $this->assertEquals(90,  $order2->total_price);
    }

    // ═══════════════════════════════════════════════════════════════════
    //  attachDishes Tests
    // ═══════════════════════════════════════════════════════════════════

    // ─── Test 6: attachDishes picks max promotion between dish and category ─
    public function test_attach_dishes_picks_max_promotion(): void
    {
        // Dish has dish promo=20, category promo=10 → should pick max = 20
        $dishPromo = Mockery::mock(BelongsToMany::class);
        $dishPromo->shouldReceive('first')->andReturn((object) ['value' => 20]);

        $categoryPromo = Mockery::mock(BelongsToMany::class);
        $categoryPromo->shouldReceive('first')->andReturn((object) ['value' => 10]);

        $category = (object) ['activePromotion' => $categoryPromo];

        $dish = (object) [
            'id'              => 1,
            'price'           => 85,
            'name'            => 'Grilled Chicken',
            'activePromotion' => $dishPromo,
            'category'        => $category,
        ];

        $dishQuantities = collect([1 => 3]);

        // نمسك الـ data اللي بتتبعت لـ attach() عشان نعمل assert عليها
        $capturedData = null;

        $relation = Mockery::mock(BelongsToMany::class);
        $relation->shouldReceive('attach')->once()
            ->andReturnUsing(function ($data) use (&$capturedData) {
                $capturedData = $data;
            });

        $order = Mockery::mock(Order::class);
        $order->shouldReceive('dishes')->once()->andReturn($relation);

        $this->service->attachDishes($order, [$dish], $dishQuantities);

        // Assertions على الـ pivot data اللي اتبعتت
        $this->assertArrayHasKey(1, $capturedData);
        $this->assertEquals(3,  $capturedData[1]['quantity']);
        $this->assertEquals(85, $capturedData[1]['dish_price_at_order']);
        $this->assertEquals('Grilled Chicken', $capturedData[1]['dish_name_at_order']);
        $this->assertEquals(20, $capturedData[1]['promotion_value']); // max(20, 10) = 20
    }
}
