<?php

namespace Tests\Feature\Promotion;

use App\Models\Admin;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexPromotionTest extends TestCase
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
            'value'      => 10,
            'start_date' => now()->subDay(),
            'end_date'   => now()->addDays(7),
            'is_active'  => true,
        ], $overrides));
    }

    private function activePromo(array $overrides = []): Promotion
    {
        return $this->createPromotion(array_merge([
            'start_date' => now()->subDay(),
            'end_date'   => now()->addDays(7),
            'is_active'  => true,
        ], $overrides));
    }

    private function expiredPromo(array $overrides = []): Promotion
    {
        return $this->createPromotion(array_merge([
            'start_date' => now()->subDays(10),
            'end_date'   => now()->subDay(),
            'is_active'  => true,
        ], $overrides));
    }

    private function scheduledPromo(array $overrides = []): Promotion
    {
        return $this->createPromotion(array_merge([
            'start_date' => now()->addDays(5),
            'end_date'   => now()->addDays(15),
            'is_active'  => true,
        ], $overrides));
    }

    // =========================================================================
    // 1) Basic data & correct structure
    // =========================================================================

    /** @test */
    public function it_returns_all_promotions_successfully(): void
    {
        $this->activePromo(['title' => 'Promo A']);
        $this->expiredPromo(['title' => 'Promo B']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /** @test */
    public function it_returns_empty_list_when_no_promotions_exist(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    /** @test */
    public function response_contains_correct_json_structure(): void
    {
        $this->activePromo(['title' => 'Structured Promo', 'promo_code' => 'CODE10']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['title', 'value', 'end_date'],
            ],
            'pagination' => ['next_cursor', 'prev_cursor', 'has_more', 'per_page'],
        ]);
    }

    /** @test */
    public function response_contains_correct_promotion_data(): void
    {
        $this->activePromo([
            'title'      => 'Summer Deal',
            'promo_code' => 'SUMMER25',
            'value'      => 25,
            'end_date'   => '2030-06-30',
        ]);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.title',      'Summer Deal');
        $response->assertJsonPath('data.0.promo_code', 'SUMMER25');
        $response->assertJsonPath('data.0.value',      25);
    }

    // =========================================================================
    // 2) Authorization
    // =========================================================================

    /** @test */
    public function customer_cannot_access_index(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer, 'customer')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(401);
    }

    // =========================================================================
    // 3) Filtering by status
    // =========================================================================

    /** @test */
    public function filter_by_status_returns_only_specific_promotions(): void
    {
        $this->activePromo(['title' => 'Active One']);
        $this->activePromo(['title' => 'Active Two']);
        $this->expiredPromo(['title' => 'Expired']);
        $this->scheduledPromo(['title' => 'Scheduled']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?status=active');

        $titles = collect($response->json('data'))->pluck('title')->toArray();
        $this->assertContains('Active One', $titles);
        $this->assertContains('Active Two', $titles);
        $this->assertNotContains('Expired', $titles);
        $this->assertNotContains('Scheduled', $titles);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?status=expired');


        $titles = collect($response->json('data'))->pluck('title')->toArray();
        $this->assertNotContains('Active One', $titles);
        $this->assertNotContains('Active Two', $titles);
        $this->assertContains('Expired', $titles);
        $this->assertNotContains('Scheduled', $titles);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?status=scheduled');


        $titles = collect($response->json('data'))->pluck('title')->toArray();
        $this->assertNotContains('Active One', $titles);
        $this->assertNotContains('Active Two', $titles);
        $this->assertNotContains('Expired', $titles);
        $this->assertContains('Scheduled', $titles);
    }

    /** @test */
    public function filter_by_status_all_returns_all_promotions(): void
    {
        $this->activePromo(['title' => 'Active']);
        $this->expiredPromo(['title' => 'Expired']);
        $this->scheduledPromo(['title' => 'Scheduled']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?status=all');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    // =========================================================================
    // 4) Filtering by search
    // =========================================================================

    /** @test */
    public function search_by_title_returns_matching_promotions(): void
    {
        $this->activePromo(['title' => 'Summer Sale']);
        $this->activePromo(['title' => 'Winter Discount']);
        $this->activePromo(['title' => 'Summer Special']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?searchBody=Summer&searchBy=title');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $titles = collect($response->json('data'))->pluck('title')->toArray();
        $this->assertContains('Summer Sale', $titles);
        $this->assertContains('Summer Special', $titles);
        $this->assertNotContains('Winter Discount', $titles);
    }

    /** @test */
    public function search_by_promo_code_returns_matching_promotions(): void
    {
        $this->activePromo(['title' => 'Promo A', 'promo_code' => 'SAVE10']);
        $this->activePromo(['title' => 'Promo B', 'promo_code' => 'SAVE20']);
        $this->activePromo(['title' => 'Promo C', 'promo_code' => 'DEAL50']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?searchBody=SAVE&searchBy=promo_code');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /** @test */
    public function search_by_all_searches_in_both_title_and_promo_code(): void
    {
        $this->activePromo(['title' => 'Hello World',  'promo_code' => 'CODE1']);
        $this->activePromo(['title' => 'Normal Promo', 'promo_code' => 'HELLO99']);
        $this->activePromo(['title' => 'Other',        'promo_code' => 'OTHER']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?searchBody=HELLO&searchBy=all');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /** @test */
    public function search_returns_empty_when_no_match_found(): void
    {
        $this->activePromo(['title' => 'Summer Sale', 'promo_code' => 'SAVE10']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?searchBody=NONEXISTENT&searchBy=title');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    /** @test */
    public function can_combine_status_and_search_filters(): void
    {
        $this->activePromo(['title'   => 'Active Summer', 'promo_code' => 'SUM1']);
        $this->expiredPromo(['title'  => 'Expired Summer', 'promo_code' => 'SUM2']);
        $this->activePromo(['title'   => 'Active Winter',  'promo_code' => 'WIN1']);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?status=active&searchBody=Summer&searchBy=title');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.title', 'Active Summer');
    }

    // =========================================================================
    // 5) Validation
    // =========================================================================

    /** @test */
    public function it_returns_422_for_invalid_status_value(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?status=unknown');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['status']);
    }

    /** @test */
    public function it_returns_422_for_invalid_searchBy_value(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions?searchBody=test&searchBy=invalid_field');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['searchBy']);
    }

    /** @test */
    public function it_accepts_all_valid_status_values(): void
    {
        foreach (['all', 'active', 'expired', 'scheduled'] as $status) {
            $response = $this->actingAs($this->admin, 'owner')
                ->getJson("/api/owner/promotions?status={$status}");

            $response->assertStatus(200, "Status '{$status}' should be accepted");
        }
    }

    /** @test */
    public function it_accepts_all_valid_searchBy_values(): void
    {
        foreach (['all', 'title', 'promo_code'] as $searchBy) {
            $response = $this->actingAs($this->admin, 'owner')
                ->getJson("/api/owner/promotions?searchBody=test&searchBy={$searchBy}");

            $response->assertStatus(200, "searchBy '{$searchBy}' should be accepted");
        }
    }

    // =========================================================================
    // 6) Ordering & Pagination
    // =========================================================================

    /** @test */
    public function results_are_ordered_by_created_at_descending(): void
    {
        // ننشئهم بترتيب معروف مع فارق زمني
        $first  = $this->activePromo(['title' => 'First']);
        $second = $this->activePromo(['title' => 'Second']);
        $third  = $this->activePromo(['title' => 'Third']);

        // نحدّث الـ created_at يدوياً لنضمن الترتيب
        $first->created_at = now()->subHours(1);
        $first->save();

        $second->created_at = now()->subHours(2);
        $second->save();

        $third->created_at = now()->subHours(4);
        $third->save();

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);

        $titles = collect($response->json('data'))->pluck('title')->values()->toArray();
        $this->assertEquals(['First', 'Second', 'Third'], $titles);
    }

    /** @test */
    public function pagination_returns_6_items_per_page(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $this->activePromo(['title' => "Promo {$i}"]);
        }

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);
        // الـ per_page المفروض يكون 6
        $this->assertEquals(6, $response->json('pagination.per_page'));
        // الـ first page فيها 6 items بس
        $response->assertJsonCount(6, 'data');
    }

    /** @test */
    public function pagination_has_next_cursor_when_more_items_exist(): void
    {
        for ($i = 1; $i <= 7; $i++) {
            $this->activePromo(['title' => "Promo {$i}"]);
        }

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);
        $this->assertTrue($response->json('pagination.has_more'));
        $this->assertNotNull($response->json('pagination.next_cursor'));
    }

    /** @test */
    public function pagination_has_no_next_cursor_when_all_items_fit_in_one_page(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $this->activePromo(['title' => "Promo {$i}"]);
        }

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $response->assertStatus(200);
        $this->assertFalse($response->json('pagination.has_more'));
        $this->assertNull($response->json('pagination.next_cursor'));
    }

    /** @test */
    public function can_navigate_to_next_page_using_cursor(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $this->activePromo(['title' => "Promo {$i}"]);
        }

        // الـ page الأولى
        $firstPage = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/owner/promotions');

        $nextCursor = $firstPage->json('pagination.next_cursor');
        $this->assertNotNull($nextCursor);

        // الـ page التانية
        $secondPage = $this->actingAs($this->admin, 'owner')
            ->getJson("/api/owner/promotions?cursor={$nextCursor}");

        $secondPage->assertStatus(200);
        $secondPage->assertJsonCount(2, 'data'); // 8 total - 6 first page = 2

        // مفيش تكرار بين الصفحتين
        $firstTitles  = collect($firstPage->json('data'))->pluck('title')->toArray();
        $secondTitles = collect($secondPage->json('data'))->pluck('title')->toArray();
        $this->assertEmpty(array_intersect($firstTitles, $secondTitles));
    }
}
