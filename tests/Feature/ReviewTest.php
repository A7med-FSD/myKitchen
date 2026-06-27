<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    private User  $customer;
    private Admin $admin;
    private Dish  $dish;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = User::factory()->create();
        $this->admin    = Admin::factory()->create();

        $category   = Category::create(['name' => 'Main Course', 'emoji' => '🍽️']);
        $this->dish = Dish::create([
            'name'           => 'Grilled Chicken',
            'description'    => 'Delicious grilled chicken',
            'price'          => 150,
            'category_id'    => $category->id,
            'time_preparing' => 30,
            'is_available'   => true,
            'image'          => 'chicken.jpg',
        ]);
    }

    // ─── Helper ────────────────────────────────────────────────────────────────

    private function createReview(array $overrides = []): Review
    {
        return Review::create(array_merge([
            'user_id'      => $this->customer->id,
            'dish_id'      => $this->dish->id,
            'rating'       => 4,
            'content'      => 'Really tasty dish!',
            'is_published' => false,
        ], $overrides));
    }

    // =========================================================================
    // STORE
    // =========================================================================

    /** @test */
    public function customer_can_submit_a_review(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', [
                'dish_id' => $this->dish->id,
                'rating'  => 5,
                'content' => 'Absolutely amazing food!',
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->customer->id,
            'dish_id' => $this->dish->id,
            'rating'  => 5,
        ]);
    }

    /** @test */
    public function user_id_is_taken_from_authenticated_user_not_from_request(): void
    {
        $anotherUser = User::factory()->create();

        $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', [
                'dish_id' => $this->dish->id,
                'rating'  => 4,
                'user_id' => $anotherUser->id, // محاولة تزوير الـ user_id
            ]);

        // الـ review المفروض يتحفظ بـ user_id بتاع الـ customer المـ authenticated
        $this->assertDatabaseHas('reviews', ['user_id' => $this->customer->id]);
        $this->assertDatabaseMissing('reviews', ['user_id' => $anotherUser->id]);
    }

    /** @test */
    public function customer_can_submit_review_without_content(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', [
                'dish_id' => $this->dish->id,
                'rating'  => 3,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reviews', ['dish_id' => $this->dish->id, 'content' => null]);
    }

    /** @test */
    public function store_fails_when_dish_id_is_missing(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', ['rating' => 4]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['dish_id']);
    }

    /** @test */
    public function store_fails_when_dish_does_not_exist(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', [
                'dish_id' => 99999,
                'rating'  => 4,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['dish_id']);
    }

    /** @test */
    public function store_fails_when_rating_is_missing(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', ['dish_id' => $this->dish->id]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rating']);
    }

    /** @test */
    public function store_fails_when_rating_exceeds_5(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', [
                'dish_id' => $this->dish->id,
                'rating'  => 6,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rating']);
    }

    /** @test */
    public function store_fails_when_rating_is_less_than_1(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->postJson('/api/review', [
                'dish_id' => $this->dish->id,
                'rating'  => 0,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rating']);
    }

    /** @test */
    public function unauthenticated_user_cannot_submit_a_review(): void
    {
        $response = $this->postJson('/api/review', [
            'dish_id' => $this->dish->id,
            'rating'  => 4,
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function owner_cannot_submit_a_review(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/review', [
                'dish_id' => $this->dish->id,
                'rating'  => 4,
            ]);

        $response->assertStatus(401);
    }

    // =========================================================================
    // INDEX
    // =========================================================================

    /** @test */
    public function customer_can_get_published_reviews(): void
    {
        $this->createReview(['is_published' => true,  'content' => 'Visible review']);
        $this->createReview(['is_published' => false, 'content' => 'Hidden review']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/review');

        $response->assertStatus(200);
        // بس الـ published بيظهر
        $response->assertJsonCount(1, 'data');
    }

    /** @test */
    public function index_does_not_return_unpublished_reviews(): void
    {
        $this->createReview(['is_published' => false, 'content' => 'Not yet approved']);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/review');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    /** @test */
    public function owner_can_get_published_reviews(): void
    {
        $this->createReview(['is_published' => true]);

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/review');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    /** @test */
    public function unauthenticated_user_cannot_get_reviews(): void
    {
        $response = $this->getJson('/api/review');

        $response->assertStatus(401);
    }

    /** @test */
    public function index_returns_reviews_ordered_by_created_at_desc(): void
    {
        $old = $this->createReview(['is_published' => true, 'content' => 'Older review']);
        $new = $this->createReview(['is_published' => true, 'content' => 'Newer review']);

        $old->update(['created_at' => now()->subHour()]);
        $new->update(['created_at' => now()]);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/review');

        $response->assertStatus(200);
        // الأحدث يجي أول
        $this->assertEquals('Newer review', $response->json('data.0.content'));
    }

    /** @test */
    public function index_returns_correct_pagination_structure_and_can_navigate_with_cursor(): void
    {
        // 1. Create 6 reviews with specific creation times to guarantee order
        for ($i = 1; $i <= 6; $i++) {
            $this->createReview([
                'is_published' => true,
                'content' => "Review {$i} content",
                // Manually set created_at so they are ordered consistently (Review 6 is newest, Review 1 is oldest)
                'created_at' => now()->addMinutes($i)
            ]);
        }

        // 2. Fetch the first page
        $firstPageResponse = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/review');

        $firstPageResponse->assertStatus(200);
        // The first page should have exactly 3 items
        $firstPageResponse->assertJsonCount(3, 'data');
        $this->assertTrue($firstPageResponse->json('pagination.has_more'));

        // Verify the order of the first page (newest first: 6, 5, 4)
        $this->assertEquals('Review 6 content', $firstPageResponse->json('data.0.content'));
        $this->assertEquals('Review 5 content', $firstPageResponse->json('data.1.content'));
        $this->assertEquals('Review 4 content', $firstPageResponse->json('data.2.content'));

        $nextCursor = $firstPageResponse->json('pagination.next_cursor');
        $this->assertNotNull($nextCursor);

        // 3. Fetch the second page using the cursor
        $secondPageResponse = $this->actingAs($this->customer, 'customer')
            ->getJson("/api/review?cursor={$nextCursor}");

        $secondPageResponse->assertStatus(200);
        // The second page should also have 3 items
        $secondPageResponse->assertJsonCount(3, 'data');
        $this->assertFalse($secondPageResponse->json('pagination.has_more'));
        $this->assertNull($secondPageResponse->json('pagination.next_cursor'));

        // Verify the order of the second page (older ones: 3, 2, 1)
        $this->assertEquals('Review 3 content', $secondPageResponse->json('data.0.content'));
        $this->assertEquals('Review 2 content', $secondPageResponse->json('data.1.content'));
        $this->assertEquals('Review 1 content', $secondPageResponse->json('data.2.content'));
    }

    // =========================================================================
    // TOGGLE PUBLISH
    // =========================================================================

    /** @test */
    public function owner_can_publish_an_unpublished_review(): void
    {
        $review = $this->createReview(['is_published' => false]);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson("/api/reviewUpdate/{$review->id}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'is_published' => true]);
    }

    /** @test */
    public function owner_can_unpublish_a_published_review(): void
    {
        $review = $this->createReview(['is_published' => true]);

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson("/api/reviewUpdate/{$review->id}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'is_published' => false]);
    }

    /** @test */
    public function toggling_twice_returns_review_to_original_state(): void
    {
        $review = $this->createReview(['is_published' => false]);

        $this->actingAs($this->admin, 'owner')->postJson("/api/reviewUpdate/{$review->id}");
        $this->actingAs($this->admin, 'owner')->postJson("/api/reviewUpdate/{$review->id}");

        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'is_published' => false]);
    }

    /** @test */
    public function customer_cannot_toggle_publish(): void
    {
        $review = $this->createReview();

        $response = $this->actingAs($this->customer, 'customer')
            ->postJson("/api/reviewUpdate/{$review->id}");

        $response->assertStatus(401);
    }

}
