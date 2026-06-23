<?php

namespace Tests\Feature\Dish;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreDishTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->admin    = Admin::factory()->create();
        $this->category = Category::create(['name' => 'Main Course', 'emoji' => '🍽️']);
    }

    // =========================================================================
    // 1) Basic data store
    // =========================================================================

    /** @test */
    public function it_stores_a_dish_with_valid_data(): void
    {
        $image = UploadedFile::fake()->image('dish.jpg');

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/dishes', [
                'name'           => 'Grilled Chicken',
                'description'    => 'Delicious grilled chicken with herbs',
                'price'          => 150,
                'category_id'    => $this->category->id,
                'time_preparing' => 30,
                'is_available'   => true,
                'image'          => $image,
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('dishes', [
            'name'        => 'Grilled Chicken',
            'price'       => 150,
            'category_id' => $this->category->id,
        ]);
    }

    /** @test */
    public function it_returns_validation_error_for_non_existent_category(): void
    {
        $image = UploadedFile::fake()->image('dish.jpg');

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/dishes', [
                'name'           => 'Test Dish',
                'description'    => 'A test description here',
                'price'          => 100,
                'category_id'    => 9999,
                'time_preparing' => 20,
                'is_available'   => true,
                'image'          => $image,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['category_id']);
    }

    // =========================================================================
    // 2) Image handling
    // =========================================================================

    /** @test */
    public function it_stores_the_uploaded_image_in_the_dishes_folder(): void
    {
        $image = UploadedFile::fake()->image('test-dish.png');

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/dishes', [
                'name'           => 'Pizza Margherita',
                'description'    => 'Classic Italian pizza with basil',
                'price'          => 200,
                'category_id'    => $this->category->id,
                'time_preparing' => 25,
                'is_available'   => true,
                'image'          => $image,
            ]);

        $response->assertStatus(201);

        // الصوره لازم تتحفظ في فولدر dishes على الـ public disk
        $dish = Dish::where('name', 'Pizza Margherita')->first();
        $this->assertNotNull($dish->image);
        Storage::disk('public')->assertExists('dishes/' . $dish->image);
    }

    /** @test */
    public function it_returns_validation_error_when_image_field_is_missing(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/dishes', [
                'name'           => 'No Image Dish',
                'description'    => 'A dish without an image',
                'price'          => 100,
                'category_id'    => $this->category->id,
                'time_preparing' => 15,
                'is_available'   => true,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }

    /** @test */
    public function it_returns_validation_error_when_file_is_not_an_image(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/dishes', [
                'name'           => 'Invalid File Dish',
                'description'    => 'Testing non-image file upload',
                'price'          => 100,
                'category_id'    => $this->category->id,
                'time_preparing' => 15,
                'is_available'   => true,
                'image'          => $file,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }

    // =========================================================================
    // 3) Authorization
    // =========================================================================

    /** @test */
    public function it_forbids_a_regular_customer_from_creating_a_dish(): void
    {
        $customer = User::factory()->create();
        $image    = UploadedFile::fake()->image('dish.jpg');

        $response = $this->actingAs($customer, 'customer')
            ->postJson('/api/owner/dishes', [
                'name'           => 'Customer Dish',
                'description'    => 'Should not be created by customer',
                'price'          => 100,
                'category_id'    => $this->category->id,
                'time_preparing' => 15,
                'is_available'   => true,
                'image'          => $image,
            ]);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('dishes', ['name' => 'Customer Dish']);
    }

    /** @test */
    public function only_an_admin_owner_can_create_a_dish(): void
    {
        $image = UploadedFile::fake()->image('admin-dish.jpg');

        $response = $this->actingAs($this->admin, 'owner')
            ->postJson('/api/owner/dishes', [
                'name'           => 'Owner Only Dish',
                'description'    => 'Created by the owner successfully',
                'price'          => 120,
                'category_id'    => $this->category->id,
                'time_preparing' => 20,
                'is_available'   => true,
                'image'          => $image,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('dishes', ['name' => 'Owner Only Dish']);
    }
}
