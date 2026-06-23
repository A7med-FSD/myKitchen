<?php

namespace Tests\Feature\Dish;

use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class mostOrderedDishesTest extends TestCase
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

    // ─── Test 1: JSON structure is correct ───────────────────────────────────
    public function test_most_ordered_dishes_returns_correct_json_structure(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes/most-ordered');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'image',
                        'rate',
                        'time_preparing',
                        'count',
                        'badge',
                        'is_available',
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

    // ─── Test 2: dishes are ordered by orders_count DESC ─────────────────────
    /**
     * From the OrderSeeder:
     *   Chocolate Lava Cake        → 4 orders (orders 2, 4, 6, 7)
     *   Grilled Chicken with Rice  → 3 orders (orders 1, 2, 5)
     *   Mixed Grill Platter        → 2 orders (orders 3, 5)
     *
     * Page 1 (perPage = 3) must come in that exact order.
     */
    public function test_dishes_are_ordered_by_orders_count_descending(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes/most-ordered');

        $response->assertStatus(200);

        $data = $response->json('data');

        // First page has exactly 3 items (perPage = 3 in DishRepository)
        $this->assertCount(3, $data);

        // Verify descending order of the 'count' field
        $this->assertGreaterThanOrEqual($data[1]['count'], $data[0]['count']);
        $this->assertGreaterThanOrEqual($data[2]['count'], $data[1]['count']);

        // Verify the exact dish names match the expected order
        $this->assertEquals('Chocolate Lava Cake', $data[0]['name']);
        $this->assertEquals(4, $data[0]['count']);
        $this->assertEquals('Grilled Chicken with Rice', $data[1]['name']);
        $this->assertEquals(3, $data[1]['count']);
        $this->assertEquals('Mixed Grill Platter', $data[2]['name']);
        $this->assertEquals(2, $data[2]['count']);
    }

    // ─── Test 3: Cursor pagination structure is present ──────────────────────
    public function test_response_contains_cursor_pagination_block(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes/most-ordered');

        $response->assertStatus(200);

        // Must have a 'pagination' block (not a page-based one)
        $pagination = $response->json('pagination');

        $this->assertArrayHasKey('next_cursor', $pagination);
        $this->assertArrayHasKey('prev_cursor', $pagination);
        $this->assertArrayHasKey('has_more', $pagination);
        $this->assertArrayHasKey('per_page', $pagination);

        // perPage is 3 as set in DishRepository
        $this->assertEquals(3, $pagination['per_page']);
    }


    // ─── Test 4: Next page loads correctly using next_cursor ─────────────────
    public function test_can_navigate_to_next_page_using_cursor(): void
    {
        // Get page 1
        $firstResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes/most-ordered');

        $firstResponse->assertStatus(200);

        $nextCursor = $firstResponse->json('pagination.next_cursor');
        $this->assertNotNull($nextCursor, 'next_cursor must not be null on the first page');

        // Get page 2 using the cursor
        $secondResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes/most-ordered?cursor=' . $nextCursor);

        $secondResponse->assertStatus(200);

        $secondPageData = $secondResponse->json('data');

        // Page 2 must not be empty
        $this->assertNotEmpty($secondPageData);

        // Items on page 2 must have a lower (or equal) count than the last item on page 1
        $lastCountOnPage1 = $firstResponse->json('data.2.count'); // Mixed Grill = 2
        $firstCountOnPage2 = $secondPageData[0]['count'];

        $this->assertLessThanOrEqual($lastCountOnPage1, $firstCountOnPage2);

        // Page 2 must have a non-null prev_cursor (we came from page 1)
        $this->assertNotNull($secondResponse->json('pagination.prev_cursor'));
    }

    // ─── Test 5: No duplicate dishes across pages ─────────────────────────────
    public function test_no_duplicate_dishes_across_pages(): void
    {
        // Collect page 1 IDs
        $firstResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes/most-ordered');

        $firstResponse->assertStatus(200);

        $page1Ids = array_column($firstResponse->json('data'), 'id');
        $nextCursor = $firstResponse->json('pagination.next_cursor');

        // Collect page 2 IDs
        $secondResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes/most-ordered?cursor=' . $nextCursor);

        $secondResponse->assertStatus(200);

        $page2Ids = array_column($secondResponse->json('data'), 'id');

        // No IDs should appear on both pages
        $duplicates = array_intersect($page1Ids, $page2Ids);
        $this->assertEmpty($duplicates, 'Dishes should not appear on more than one page');
    }
}
