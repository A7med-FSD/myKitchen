<?php

namespace Tests\Feature\Dish;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OwnerSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetDishesTest extends TestCase
{
    use RefreshDatabase;

    private User $ahmed;
    private int $grilledCategoryId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            UserSeeder::class,
            CategorySeeder::class,
            DishSeeder::class,
            OrderSeeder::class,
            OwnerSeeder::class
        ]);

        $this->ahmed = User::where('email', 'ahmed@example.com')->first();
        $this->grilledCategoryId = Category::where('name', 'Grills')->first()->id;
    }

    // ─── Test 1: Response has correct JSON structure ──────────────────────────
    public function test_dishes_returns_correct_json_structure(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'image',
                        'category',   
                        'rate',
                        'time_preparing',
                        'count',      
                        'promotion',  
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

    // ─── Test 2: Per-page is 4 as set in the repository ──────────────────────
    public function test_per_page_is_4(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes');

        $response->assertStatus(200);

        $this->assertEquals(4, $response->json('pagination.per_page'));
        $this->assertCount(4, $response->json('data'));
    }

    // ─── Test 3: Filter by category_id returns only dishes of that category ──

    public function test_filter_by_category_id_returns_correct_dishes(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?category_id=' . $this->grilledCategoryId);

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(2, $data);

        foreach ($data as $dish) {
            $this->assertEquals('Grills', $dish['category']);
        }
    }

    // ─── Test 4: Filter by badge=featured returns only featured dishes ────────

    public function test_filter_by_badge_dishes(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?badge=featured');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(2, $data);

        foreach ($data as $dish) {
            $this->assertEquals('featured', $dish['badge']);
        }
    }


    // ─── Test 9: badge=all ignores the badge filter ───────────────────────────
    public function test_badge_all_returns_all_available_dishes(): void
    {
        $allResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes');

        $badgeAllResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?badge=all');

        // Both responses should have the same first page count and per_page
        $this->assertEquals(
            $allResponse->json('pagination.per_page'),
            $badgeAllResponse->json('pagination.per_page')
        );
        $this->assertCount(
            count($allResponse->json('data')),
            $badgeAllResponse->json('data')
        );
    }

    // ─── Test 10: Search by name ──────────────────────────────────────────────

    public function test_search_by_name_returns_matching_dishes(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?searchBody=Chicken&searchBy=name');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(2, $data);

        foreach ($data as $dish) {
            $this->assertStringContainsStringIgnoringCase('Chicken', $dish['name']);
        }
    }

    // ─── Test 11: Search by description ──────────────────────────────────────

    public function test_search_by_description_returns_matching_dishes(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?searchBody=lemon&searchBy=description');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(1, $data);
        $this->assertEquals('Lentil Soup', $data[0]['name']);
    }

    // ─── Test 12: Search by all (name OR description) ────────────────────────
    public function test_search_by_all_searches_name_and_description(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?searchBody=Italian&searchBy=all');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(1, $data);
        $this->assertEquals('Pasta Bolognese', $data[0]['name']);
    }

    // ─── Test 13: searchBy is required when searchBody is present ─────────────
    public function test_search_without_searchBy_returns_validation_error(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?searchBody=chicken');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['searchBy']);
    }
    
    // ─── Test 15: Cursor pagination works end-to-end ─────────────────────────

    public function test_cursor_pagination_navigates_to_next_page(): void
    {
        // ── Step 1: Page 1 ───────────────────────────────────────────────────
        $firstResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes');

        $firstResponse->assertStatus(200);

        $pagination = $firstResponse->json('pagination');

        // Cursor keys must be present
        $this->assertArrayHasKey('next_cursor', $pagination);
        $this->assertArrayHasKey('prev_cursor', $pagination);
        $this->assertArrayHasKey('has_more',    $pagination);
        $this->assertArrayHasKey('per_page',    $pagination);

        // 13 dishes > 4 per page → has_more = true on page 1
        $this->assertTrue($pagination['has_more'],       'Page 1 must have more pages (13 dishes, 4 per page)');
        $this->assertNull($pagination['prev_cursor'],    'prev_cursor must be null on the first page');
        $this->assertNotNull($pagination['next_cursor'], 'next_cursor must not be null on the first page');

        // ── Step 2: Use next_cursor to navigate to page 2 ───────────────────
        $nextCursor = $pagination['next_cursor'];

        $secondResponse = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?cursor=' . $nextCursor);

        $secondResponse->assertStatus(200);

        $secondData       = $secondResponse->json('data');
        $secondPagination = $secondResponse->json('pagination');

        // Page 2 must not be empty
        $this->assertNotEmpty($secondData, 'Page 2 must not be empty');

        // ── Step 3: No duplicate dishes across pages ─────────────────────────
        $page1Ids = array_column($firstResponse->json('data'), 'id');
        $page2Ids = array_column($secondData, 'id');

        $this->assertEmpty(
            array_intersect($page1Ids, $page2Ids),
            'Dishes must not appear on more than one page'
        );

        // ── Step 4: Alphabetical ordering is preserved across the boundary ───
        $lastNamePage1  = $firstResponse->json('data.3.name'); // last item on page 1
        $firstNamePage2 = $secondData[0]['name'];              // first item on page 2

        $this->assertLessThanOrEqual(
            0,
            strcmp($lastNamePage1, $firstNamePage2),
            "Last dish on page 1 ('{$lastNamePage1}') must come before first dish on page 2 ('{$firstNamePage2}') alphabetically"
        );

        // ── Step 5: Page 2 must have a prev_cursor pointing back ────────────
        $this->assertNotNull($secondPagination['prev_cursor'], 'prev_cursor must not be null on page 2');
    }

    // ─── Test: Customer sending is_available gets validation error ────────────
    public function test_customer_sending_is_available_gets_prohibited(): void
    {
        $response = $this->actingAs($this->ahmed, 'customer')
            ->getJson('/api/dishes?is_available=0');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['is_available']);
    }

    // ─── Test: Owner sending is_available filters dishes correctly ────────────
    public function test_owner_can_filter_by_is_available(): void
    {
        $owner = \App\Models\Admin::where('email', 'owner@mykitchen.com')->first();

        $response = $this->actingAs($owner, 'owner')
            ->getJson('/api/owner/dishes?is_available=0');

        $response->assertStatus(200);
        $data = $response->json('data');

        // Seeder فيه dish واحد بس is_available=false (Beef Kofta)
        $this->assertCount(1, $data);
        $this->assertEquals('Beef Kofta', $data[0]['name']);
        $this->assertFalse((bool) $data[0]['is_available']);
    }
}
