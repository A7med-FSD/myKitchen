<?php

namespace Tests\Feature\Order;

use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\OrderSeeder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;

    private User $ahmed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            UserSeeder::class,
            CategorySeeder::class,
            DishSeeder::class,
            OrderSeeder::class,
        ]);

        $this->ahmed = User::where('email', 'ahmed@example.com')->first();
    }

    // ─── Test 1: JSON Structure matches OrderResource ───────────────────
    public function test_orders_returns_correct_json_structure(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'customer_name',
                        'customer_phone',
                        'order_code',
                        'status',
                        'total_price_before_promotion',
                        'total_price',
                        'created_at',
                        'address_text',
                        'location' => ['latitude', 'longitude'],
                        'dishes' => [
                            '*' => [
                                'name',
                                'price',
                                'total_price_before_promotion',
                                'quantity',
                                'total_price_after_promotion',
                                'promotion',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    // ─── Test 2: User only sees their own orders ────────────────────────
    public function test_user_only_sees_own_orders(): void
    {
        // Ahmed has 4 orders in the seeder (0001, 0002, 0003, 0007)
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/orders');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(4, $data);

        foreach ($data as $order) {
            $this->assertEquals('Ahmed Ali', $order['customer_name']);
        }
    }

    // ─── Test 3: Search by exact order_code ─────────────────────────────
    public function test_search_by_order_code_returns_matching_order(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/orders?order_code=20260509-0007');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('20260509-0007', $data[0]['order_code']);
    }

    // ─── Test 4: Filter by time=week ────────────────────────────────────
    public function test_filter_by_week_returns_only_recent_orders(): void
    {
        // Ahmed: order 20260509-0001 (3 days ago) → should appear
        // 20260509-0002 (20 days), 20260509-0003 (6 months), 20260509-0007 (18 months) → should NOT
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/orders?time=week');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('20260509-0001', $data[0]['order_code']);
    }

    // ─── Test 5: Filter by time=month ───────────────────────────────────
    public function test_filter_by_month_returns_orders_within_last_month(): void
    {
        // Ahmed: 20260509-0001 (3 days) + 20260509-0002 (20 days) → should appear
        // 20260509-0003 (6 months), 20260509-0007 (18 months) → should NOT
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/orders?time=month');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(2, $data);
    }

    // ─── Test 6: Filter by time=year ────────────────────────────────────
    public function test_filter_by_year_returns_orders_within_last_year(): void
    {
        // Ahmed: 20260509-0001 (3 days) + 20260509-0002 (20 days) + 20260509-0003 (6 months) → should appear
        // 20260509-0007 (18 months) → should NOT
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/orders?time=year');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(3, $data);
    }
}
