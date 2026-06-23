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

class UpdateDishTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;
    private Category $category;
    private Dish $dish;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->admin    = Admin::factory()->create();
        $this->category = Category::create(['name' => 'Starters', 'emoji' => '🥗']);

        // إنشاء صورة وهمية وحفظها على الـ fake disk
        $fakeImage = UploadedFile::fake()->image('existing.jpg');
        $imageName = 'existing.jpg';
        Storage::disk('public')->putFileAs('dishes', $fakeImage, $imageName);

        $this->dish = Dish::create([
            'name'           => 'Original Dish',
            'description'    => 'Original description for testing',
            'price'          => 100,
            'category_id'    => $this->category->id,
            'time_preparing' => 20,
            'is_available'   => true,
            'image'          => $imageName,
        ]);
    }

    // =========================================================================
    // 1) Basic data update
    // =========================================================================

    /** @test */
    public function it_updates_dish_basic_data_successfully(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/dishes/{$this->dish->id}", [
                'name'        => 'Updated Dish Name',
                'description' => 'Updated description text',
                'price'       => 250,
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('dishes', [
            'id'          => $this->dish->id,
            'name'        => 'Updated Dish Name',
            'price'       => 250,
            'description' => 'Updated description text',
        ]);
    }

    // =========================================================================
    // 2) Image update (القديمة تتمسح والجديدة تتحفظ)
    // =========================================================================

    /** @test */
    public function it_replaces_old_image_with_new_one_on_update(): void
    {
        $oldImageName = $this->dish->image; // existing.jpg
        $newImage     = UploadedFile::fake()->image('new-dish.png');

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/dishes/{$this->dish->id}", [
                'image' => $newImage,
            ]);

        $response->assertStatus(200);

        // الصورة القديمة لازم تتمسح
        Storage::disk('public')->assertMissing('dishes/' . $oldImageName);

        // الصورة الجديدة لازم تتحفظ
        $this->dish->refresh();
        $this->assertNotNull($this->dish->image);
        $this->assertNotEquals($oldImageName, $this->dish->image);
        Storage::disk('public')->assertExists('dishes/' . $this->dish->image);
    }

    /** @test */
    public function it_returns_validation_error_when_uploaded_file_is_not_an_image(): void
    {
        $file = UploadedFile::fake()->create('doc.pdf', 200, 'application/pdf');

        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/dishes/{$this->dish->id}", [
                'image' => $file,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }

    // =========================================================================
    // 3) Authorization
    // =========================================================================
    
    /** @test */
    public function it_forbids_a_regular_customer_from_updating_a_dish(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer, 'customer')
            ->patchJson("/api/owner/dishes/{$this->dish->id}", [
                'name' => 'Customer Updated Dish',
            ]);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('dishes', ['name' => 'Customer Updated Dish']);
    }

    /** @test */
    public function only_an_admin_owner_can_update_a_dish(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->patchJson("/api/owner/dishes/{$this->dish->id}", [
                'name' => 'Admin Updated Dish',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('dishes', [
            'id'   => $this->dish->id,
            'name' => 'Admin Updated Dish',
        ]);
    }
}
