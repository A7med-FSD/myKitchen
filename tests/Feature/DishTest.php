<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DishTest extends TestCase
{
    use RefreshDatabase;

    private function createDishWithOrders(array $dishData, int $orderCount): Dish
    {
        $category = Category::create(['name' => 'Test Category', 'emoji' => '🍽️']);

        $dish = Dish::create(array_merge([
            'name'           => 'Test Dish',
            'description'    => 'A test dish',
            'price'          => 50,
            'time_preparing' => 10,
            'image'          => 'test.jpg',
            'is_available'   => true,
            'category_id'    => $category->id,
        ], $dishData));

        for ($i = 0; $i < $orderCount; $i++) {
            $order = new Order([
                'customer_name'  => 'Test Customer',
                'customer_phone' => '01000000000',
                'status'         => 'delivered',
                'payment_method' => 'cash',
            ]);

            $order->order_code = 1000 + $i;
            $order->total_price = 2000 + $i;
            $order->save(); 

            $order->dishes()->attach($dish->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $dish->price,
                'dish_name_at_order'  => $dish->name,
                'promotion_value'     => null,
            ]);
        }

        return $dish;
    }

    private function createPromotion(Dish $dish, bool $isActive, string $createdAt = null): Promotion
    {
        $promo = Promotion::create([
            'title'       => 'Promo for ' . $dish->name,
            'promo_code'  => 'CODE' . rand(100, 999),
            'apply_to'    => 'dishes',
            'value'       => 20,
            'start_date'  => now()->subDay(),
            'end_date'    => now()->addDays(5),
            'is_active'   => $isActive,
            'total_price' => 2000
        ]);

        if ($createdAt) {
            $promo->created_at = $createdAt;
            $promo->save();
        }

        $dish->promotions()->attach($promo->id);

        return $promo;
    }


    public function test_most_ordered_dishes_returns_data_with_one_having_no_promotion(): void
    {
        $dishWithPromo = $this->createDishWithOrders(['name' => 'Dish With Promo'], 3);
        $this->createPromotion($dishWithPromo, isActive: true);

        $this->createDishWithOrders(['name' => 'Dish No Promo'], 2);

        $this->createDishWithOrders(['name' => 'Dish One Order'], 1);

        $response = $this->getJson('/api/dishes/most-ordered');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'name', 'price', 'category', 'count'],
                    ],
                    'pagination' => ['next_cursor', 'prev_cursor', 'has_more', 'per_page'],
                ]);

        $data = $response->json('data');

        $this->assertEquals('Dish With Promo', $data[0]['name']);
        $this->assertEquals('Dish No Promo',   $data[1]['name']);
        $this->assertEquals('Dish One Order',   $data[2]['name']);

        $promotionValues = collect($data)->pluck('promotion');
        $this->assertTrue($promotionValues->contains(null));
    }


    public function test_dish_with_inactive_promotion_returns_null_promotion(): void
    {
        $dish = $this->createDishWithOrders(['name' => 'Inactive Promo Dish'], 2);

        $this->createPromotion($dish, isActive: false);

        $response = $this->getJson('/api/dishes/most-ordered');

        $response->assertStatus(200);

        $dishData = collect($response->json('data'))
            ->firstWhere('name', 'Inactive Promo Dish');

        $this->assertNotNull($dishData, 'الطبق مش موجود في الـ response');
        $this->assertNull($dishData['promotion'], 'المفروض promotion = null لأن الـ promotion مش active');
    }

    // ─── Test 3: Two Active Promotions — Latest Wins ───────────────────────

    public function test_dish_with_two_active_promotions_returns_latest_one(): void
    {
        $dish = $this->createDishWithOrders(['name' => 'Multi Promo Dish'], 3);

        $olderPromo = $this->createPromotion($dish, isActive: true, createdAt: now()->subDays(5)->toDateTimeString());
        $olderPromo->update(['value' => 10]);

        $newerPromo = $this->createPromotion($dish, isActive: true, createdAt: now()->subDay()->toDateTimeString());
        $newerPromo->update(['value' => 30]);

        $response = $this->getJson('/api/dishes/most-ordered');

        $response->assertStatus(200);

        $dishData = collect($response->json('data'))
            ->firstWhere('name', 'Multi Promo Dish');

        $this->assertNotNull($dishData, 'الطبق مش موجود في الـ response');
        $this->assertEquals(
            30,
            $dishData['promotion'],
            'المفروض يرجع الـ promotion الأحدث (value = 30) مش الأقدم (value = 10)'
        );
    }
}
