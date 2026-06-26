<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    // =========================================================================
    // Helper
    // =========================================================================

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'            => 'Tomato',
            'category'        => 'Vegetables',
            'unit'            => 'kg',
            'price_per_unit'  => 15,
            'quantity'        => 50,
            'low_stock_alert' => 10,
        ], $overrides);
    }

    // =========================================================================
    // INDEX
    // =========================================================================

    /** @test */
    public function owner_can_list_all_ingredients(): void
    {
        Ingredient::create($this->validPayload(['name' => 'Salt']));
        Ingredient::create($this->validPayload(['name' => 'Sugar']));

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/ingredients');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /** @test */
    public function index_returns_correct_json_structure(): void
    {
        Ingredient::create($this->validPayload(['name' => 'Pepper']));

        $response = $this->actingAs($this->admin, 'owner')
            ->getJson('/api/ingredients');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['name', 'category', 'quantity', 'unit', 'price_per_unit', 'low_stock_alert'],
            ],
        ]);
    }

    /** @test */
    public function customer_cannot_list_ingredients(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer, 'customer')
            ->getJson('/api/ingredients');

        $response->assertStatus(401);
    }

    // =========================================================================
    // STORE
    // =========================================================================

    /** @test */
    public function owner_can_create_an_ingredient(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/ingredients', $this->validPayload());

        $response->assertStatus(201);
        $this->assertDatabaseHas('ingredients', ['name' => 'Tomato']);
    }

    /** @test */
    public function store_fails_when_required_fields_are_missing(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/ingredients', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'category', 'unit', 'price_per_unit', 'quantity', 'low_stock_alert']);
    }

    /** @test */
    public function store_fails_when_name_is_already_taken(): void
    {
        Ingredient::create($this->validPayload(['name' => 'Salt']));

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/ingredients', $this->validPayload(['name' => 'Salt']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function store_fails_with_invalid_unit(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/ingredients', $this->validPayload(['unit' => 'cup']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['unit']);
    }

    /** @test */
    public function customer_cannot_create_an_ingredient(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer, 'customer')
            ->postJson('/api/ingredients', $this->validPayload());

        $response->assertStatus(401);
        $this->assertDatabaseMissing('ingredients', ['name' => 'Tomato']);
    }

    // =========================================================================
    // UPDATE
    // =========================================================================

    /** @test */
    public function owner_can_partially_update_an_ingredient(): void
    {
        $ingredient = Ingredient::create($this->validPayload(['name' => 'Olive Oil']));

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/ingredients/{$ingredient->id}", [
                'price_per_unit' => 999,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ingredients', [
            'id'             => $ingredient->id,
            'name'           => 'Olive Oil',
            'price_per_unit' => 999,
        ]);
    }

    /** @test */
    public function update_fails_when_name_is_already_taken_by_another_ingredient(): void
    {
        Ingredient::create($this->validPayload(['name' => 'Existing']));
        $ingredient = Ingredient::create($this->validPayload(['name' => 'Target']));

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/ingredients/{$ingredient->id}", [
                'name' => 'Existing',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function update_returns_404_when_ingredient_not_found(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson('/api/ingredients/9999', ['name' => 'Ghost']);

        $response->assertStatus(404); 
    }

    /** @test */
    public function customer_cannot_update_an_ingredient(): void
    {
        $customer   = User::factory()->create();
        $ingredient = Ingredient::create($this->validPayload());

        $response = $this->actingAs($customer, 'customer')
            ->patchJson("/api/ingredients/{$ingredient->id}", ['name' => 'Hacked']);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('ingredients', ['name' => 'Hacked']);
    }

    // =========================================================================
    // DELETE
    // =========================================================================

    /** @test */
    public function owner_can_delete_an_ingredient(): void
    {
        $ingredient = Ingredient::create($this->validPayload());

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/ingredients/{$ingredient->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('ingredients', ['id' => $ingredient->id]);
    }

    /** @test */
    public function delete_returns_500_when_ingredient_not_found(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson('/api/ingredients/9999');

        $response->assertStatus(404);
    }

    /** @test */
    public function customer_cannot_delete_an_ingredient(): void
    {
        $customer   = User::factory()->create();
        $ingredient = Ingredient::create($this->validPayload());

        $response = $this->actingAs($customer, 'customer')
            ->deleteJson("/api/ingredients/{$ingredient->id}");

        $response->assertStatus(401);
        $this->assertDatabaseHas('ingredients', ['id' => $ingredient->id]);
    }

}
