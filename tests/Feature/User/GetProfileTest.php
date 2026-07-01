<?php

namespace Tests\Feature\User;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GetProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = User::factory()->create([
            'name'  => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'phone' => '01012345678',
        ]);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    private function createCategory(string $name): Category
    {
        return Category::create(['name' => $name, 'emoji' => '🍽️']);
    }

    private function createDish(int $categoryId, string $name = 'Test Dish'): Dish
    {
        return Dish::create([
            'name'           => $name,
            'description'    => 'A tasty dish',
            'price'          => 100,
            'category_id'    => $categoryId,
            'time_preparing' => 20,
            'is_available'   => true,
            'image'          => 'dish.jpg',
        ]);
    }

    /**
     * ينشئ order مع attach dishes في الـ pivot
     */
    private function createOrderWithDishes(User $user, array $dishes, array $orderOverrides = []): Order
    {
        $order = DB::table('orders')->insertGetId(array_merge([
            'customer_phone'  => '01099999999',
            'customer_name'   => $user->name,
            'status'          => 'delivered',
            'order_code'      => uniqid('ORD-'),
            'address_text'    => '123 Test Street',
            'payment_method'  => 'visa',
            'user_id'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ], $orderOverrides));

        foreach ($dishes as $dish) {
            DB::table('dish_order')->insert([
                'order_id'               => $order,
                'dish_id'                => $dish->id,
                'quantity'               => 1,
                'dish_price_at_order'    => $dish->price,
                'dish_name_at_order'     => $dish->name,
                'promotion_value'        => null,
            ]);
        }

        return Order::find($order);
    }

    // =========================================================================
    // 1) Authorization
    // =========================================================================

    /** @test */
    public function unauthenticated_user_cannot_get_profile(): void
    {
        $response = $this->getJson('/api/user/profile');

        $response->assertStatus(401);
    }

    /** @test */
    public function owner_cannot_access_customer_profile_endpoint(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'owner')
            ->getJson('/api/user/profile');

        $response->assertStatus(401);
    }

    // =========================================================================
    // 2) Basic data
    // =========================================================================

    /** @test */
    public function customer_can_get_their_profile(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
    }

    /** @test */
    public function profile_returns_correct_user_data(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
        $response->assertJsonPath('data.name',  'Ahmed Ali');
        $response->assertJsonPath('data.email', 'ahmed@example.com');
        $response->assertJsonPath('data.phone', '01012345678');
    }

    /** @test */
    public function profile_returns_correct_json_structure(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'phone',
                'orders_count',
            ],
        ]);
    }

    // =========================================================================
    // 3) orders_count صح
    // =========================================================================

    /** @test */
    public function profile_returns_zero_orders_count_when_user_has_no_orders(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
        $response->assertJsonPath('data.orders_count', 0);
    }

    /** @test */
    public function profile_returns_correct_orders_count(): void
    {
        $category = $this->createCategory('Grills');
        $dish     = $this->createDish($category->id);

        $this->createOrderWithDishes($this->customer, [$dish]);
        $this->createOrderWithDishes($this->customer, [$dish]);
        $this->createOrderWithDishes($this->customer, [$dish]);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
        $response->assertJsonPath('data.orders_count', 3);
    }

    /** @test */
    public function orders_count_only_counts_orders_belonging_to_authenticated_user(): void
    {
        $otherUser = User::factory()->create();
        $category  = $this->createCategory('Soups');
        $dish      = $this->createDish($category->id);

        // 2 orders للـ customer الحالي
        $this->createOrderWithDishes($this->customer, [$dish]);
        $this->createOrderWithDishes($this->customer, [$dish]);

        // 5 orders لـ user تاني — المفروض ميتحسبوش
        for ($i = 0; $i < 5; $i++) {
            $this->createOrderWithDishes($otherUser, [$dish]);
        }

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertJsonPath('data.orders_count', 2);
    }

    // =========================================================================
    // 4) favorite_category - الـ query المعقدة
    // =========================================================================

    /** @test */
    public function favorite_category_is_absent_when_user_has_no_orders(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
        // لو مفيش orders، المفروض favorite_category ميتبعتش
        $this->assertArrayNotHasKey('favorite_category', $response->json('data'));
    }

    /** @test */
    public function favorite_category_returns_the_most_ordered_category(): void
    {
        $grills   = $this->createCategory('Grills');
        $desserts = $this->createCategory('Desserts');
        $pasta    = $this->createCategory('Pasta');

        $grillDish   = $this->createDish($grills->id,   'Grilled Chicken');
        $dessertDish = $this->createDish($desserts->id, 'Chocolate Cake');
        $pastaDish   = $this->createDish($pasta->id,    'Spaghetti');

        // Grills: 4 orders — المفروض يكون الـ favorite
        $this->createOrderWithDishes($this->customer, [$grillDish]);
        $this->createOrderWithDishes($this->customer, [$grillDish]);
        $this->createOrderWithDishes($this->customer, [$grillDish]);
        $this->createOrderWithDishes($this->customer, [$grillDish]);

        // Desserts: 2 orders
        $this->createOrderWithDishes($this->customer, [$dessertDish]);
        $this->createOrderWithDishes($this->customer, [$dessertDish]);

        // Pasta: 1 order
        $this->createOrderWithDishes($this->customer, [$pastaDish]);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
        $this->assertEquals('Grills', $response->json('data.favorite_category.name'));
    }

    /** @test */
    public function favorite_category_ignores_orders_from_other_users(): void
    {
        $otherUser = User::factory()->create();
        $grills    = $this->createCategory('Grills');
        $desserts  = $this->createCategory('Desserts');

        $grillDish   = $this->createDish($grills->id,   'Grilled Chicken');
        $dessertDish = $this->createDish($desserts->id, 'Cake');

        // الـ customer الحالي: 1 order بس من Grills
        $this->createOrderWithDishes($this->customer, [$grillDish]);

        // الـ other user: 10 orders من Desserts — المفروض ميأثروش
        for ($i = 0; $i < 10; $i++) {
            $this->createOrderWithDishes($otherUser, [$dessertDish]);
        }

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        // الـ favorite بتاع الـ customer المفروض يكون Grills مش Desserts
        $this->assertEquals('Grills', $response->json('data.favorite_category.name'));
    }

    /** @test */
    public function favorite_category_is_determined_by_dish_count_not_order_count_per_se(): void
    {
        $grills   = $this->createCategory('Grills');
        $desserts = $this->createCategory('Desserts');

        $grillDish1  = $this->createDish($grills->id,   'Chicken');
        $grillDish2  = $this->createDish($grills->id,   'Beef');
        $dessertDish = $this->createDish($desserts->id, 'Cake');

        // order واحدة فيها 2 dishes من Grills → category تتحسب مرتين
        $this->createOrderWithDishes($this->customer, [$grillDish1, $grillDish2]);
        // order واحدة من Desserts → تتحسب مرة واحدة
        $this->createOrderWithDishes($this->customer, [$dessertDish]);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $this->assertEquals('Grills', $response->json('data.favorite_category.name'));
    }

    // =========================================================================
    // 5) last_order
    // =========================================================================

    /** @test */
    public function last_order_is_absent_when_user_has_no_orders(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $this->assertArrayNotHasKey('last_order', $response->json('data'));
    }

    /** @test */
    public function last_order_returns_the_most_recent_order_timestamp(): void
    {
        $category = $this->createCategory('Grills');
        $dish     = $this->createDish($category->id);

        $oldOrderTime  = now()->subDays(5)->format('Y-m-d H:i:s');
        $newOrderTime  = now()->subDay()->format('Y-m-d H:i:s');

        $this->createOrderWithDishes($this->customer, [$dish], ['created_at' => $oldOrderTime]);
        $this->createOrderWithDishes($this->customer, [$dish], ['created_at' => $newOrderTime]);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $response->assertStatus(200);
        // التاريخ في الـ response لازم يطابق آخر order
        $this->assertStringContainsString(
            now()->subDay()->format('Y-m-d'),
            $response->json('data.last_order.created_at')
        );
    }

    /** @test */
    public function last_order_only_returns_created_at_field(): void
    {
        $category = $this->createCategory('Grills');
        $dish     = $this->createDish($category->id);

        $this->createOrderWithDishes($this->customer, [$dish]);

        $response = $this->actingAs($this->customer, 'customer')
            ->getJson('/api/user/profile');

        $lastOrder = $response->json('data.last_order');

        $this->assertArrayHasKey('created_at', $lastOrder);
        // بيرجع created_at بس — مش كل بيانات الـ order
        $this->assertCount(1, $lastOrder);
    }
}
