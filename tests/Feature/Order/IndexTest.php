<?php

namespace Tests\Feature\Order;

use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OwnerSeeder;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    private Admin $owner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            UserSeeder::class,
            CategorySeeder::class,
            DishSeeder::class,
            OrderSeeder::class,
            OwnerSeeder::class,
        ]);

        $this->owner = Admin::where('email', 'owner@mykitchen.com')->first();
    }

    // ─── Test 1: JSON structure + pagination keys ───────────────────────
    public function test_index_returns_correct_json_structure_with_pagination(): void
    {
        // dd($this->owner); فعلا هو ال owner  
        $response = $this->actingAs($this->owner, 'owner')
            ->getJson('/api/owner/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'customer_name',
                        'customer_phone',
                        'order_code',
                        'status',
                        'total_price',
                        'dishes',
                    ],
                ],
                'pagination' => [
                    'next_cursor',
                    'prev_cursor',
                    'has_more',
                    'per_page',
                ],
            ]);
    }

    // ─── Test 2: Pagination returns max 4 per page ──────────────────────
    public function test_index_paginates_with_4_per_page(): void
    {
        // Total seeded orders = 7 (4 Ahmed + 3 Sara), so first page = 4, has_more = true
        $response = $this->actingAs($this->owner, 'owner')
            ->getJson('/api/owner/orders');

        $response->assertStatus(200);
        $data = $response->json('data');
        $pagination = $response->json('pagination');

        $this->assertCount(4, $data);
        $this->assertEquals(4, $pagination['per_page']);
        $this->assertTrue($pagination['has_more']);
        $this->assertNotNull($pagination['next_cursor']);
    }

    // ─── Test 3: Filter by status=delivered ──────────────────────────────
    public function test_filter_by_status_delivered(): void
    {
        // Seeder: orders 20260509-0001..0004 (Ahmed) + 20260509-0004..0006 (Sara) = 6 delivered
        // Order 20260509-0005 (Sara) = in_progress
        $response = $this->actingAs($this->owner, 'owner')
            ->getJson('/api/owner/orders?status=delivered');

        $response->assertStatus(200);
        $data = $response->json('data');

        foreach ($data as $order) {
            $this->assertEquals('delivered', $order['status']);
        }
    }

    // ─── Test 4: Search by customer_name ─────────────────────────────────
    public function test_search_by_customer_name(): void
    {
        $response = $this->actingAs($this->owner, 'owner')
            ->getJson('/api/owner/orders?searchBody=Sara&searchBy=customer_name');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(3, $data);

        foreach ($data as $order) {
            $this->assertEquals('Sara Mohamed', $order['customer_name']);
        }
    }

    // ─── Test 5: Search by order_code ────────────────────────────────────
    public function test_search_by_order_code(): void
    {
        $response = $this->actingAs($this->owner, 'owner')
            ->getJson('/api/owner/orders?searchBody=20260509-0005&searchBy=order_code');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('20260509-0005', $data[0]['order_code']);
    }

    // ─── Test 6: Search by customer_phone ────────────────────────────────
    public function test_search_by_customer_phone(): void
    {
        // Ahmed's phone: 01001234567
        $response = $this->actingAs($this->owner, 'owner')
            ->getJson('/api/owner/orders?searchBody=01001234567&searchBy=customer_phone');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(4, $data);

        foreach ($data as $order) {
            $this->assertEquals('01001234567', $order['customer_phone']);
        }
    }
}
