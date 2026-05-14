<?php

namespace Tests\Feature\Order;

use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\PromotionSeeder;
use App\Models\User;
use App\Models\Dish;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceOrderTest extends TestCase
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
            PromotionSeeder::class,
        ]);

        $this->ahmed = User::where('email', 'ahmed@example.com')->first();
    }

    private function validOrderPayload(array $overrides = []): array
    {
        $chicken = Dish::where('name', 'Grilled Chicken with Rice')->first();
        $cake    = Dish::where('name', 'Chocolate Lava Cake')->first();
        $pasta   = Dish::where('name', 'Pasta Bolognese')->first(); // no promotions 

        return array_merge([
            'customer_name'  => 'Ahmed Ali',
            'customer_phone' => '+201001234567',
            'address_text'   => '123 Nile St, Cairo',
            'payment_method' => 'visa',
            'dishes' => [
                ['id' => $cake->id,    'quantity' => 1],
                ['id' => $chicken->id, 'quantity' => 2],
                ['id' => $pasta->id ,  'quantity' => 2],
            ],
        ], $overrides);
    }

    // ─── Test 1: Order row is created in DB ─────────────────────────────
    public function test_place_order_creates_row_in_database(): void
    {
        $payload = $this->validOrderPayload();

        $response = $this->actingAs($this->ahmed, 'customer')
            ->postJson('/api/orders', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('orders', [
            'user_id'        => $this->ahmed->id,
            'customer_name'  => 'Ahmed Ali',
            'customer_phone' => '+201001234567',
            'address_text'   => '123 Nile St, Cairo',
            'payment_method' => 'visa',
            'status'         => 'pending',
        ]);
    }

    // ─── Test 2: Promotion value is set when valid promo_code is sent ───
    public function test_place_order_with_valid_promo_code_sets_promotion_value(): void
    {
        // MENU15 = all_menu promotion, value=15, active now
        $payload = $this->validOrderPayload(['promo_code' => 'MENU15']);

        $response = $this->actingAs($this->ahmed, 'customer')
            ->postJson('/api/orders', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->ahmed->id,
            'promotion_value' => 15,
        ]);
    }

    // ─── Test 3: Dishes are attached in pivot table ─────────────────────
    public function test_place_order_attaches_dishes_in_pivot(): void
    {
        $chicken = Dish::where('name', 'Grilled Chicken with Rice')->first();
        $cake    = Dish::where('name', 'Chocolate Lava Cake')->first();
        $pasta   = Dish::where('name', 'Pasta Bolognese')->first();

        $payload = $this->validOrderPayload();

        $response = $this->actingAs($this->ahmed, 'customer')
            ->postJson('/api/orders', $payload);

        $response->assertStatus(201);

        // Chicken: quantity=2, has active dish promotion (value=20)
        $this->assertDatabaseHas('dish_order', [
            'dish_id'             => $chicken->id,
            'quantity'            => 2,
            'dish_price_at_order' => $chicken->price,
            'dish_name_at_order'  => $chicken->name,
        ]);

        // Cake: quantity=1
        $this->assertDatabaseHas('dish_order', [
            'dish_id'             => $cake->id,
            'quantity'            => 1,
            'dish_price_at_order' => $cake->price,
            'dish_name_at_order'  => $cake->name,
        ]);

        // Verify at least one dish has a promotion_value (not null)
        // Chicken has dish promo=20, Cake has category promo=10 (Desserts)
        $this->assertDatabaseHas('dish_order', [
            'dish_id'         => $chicken->id,
            'promotion_value' => 20,
        ]);
        $this->assertDatabaseHas('dish_order', [
            'dish_id'         => $cake->id,
            'promotion_value' => 10,
        ]);
        $this->assertDatabaseHas('dish_order', [
            'dish_id'         => $pasta->id,
            'promotion_value' => null,
        ]);
    }
}
