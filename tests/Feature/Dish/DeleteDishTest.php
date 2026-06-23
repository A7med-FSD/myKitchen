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

class DeleteDishTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->admin    = Admin::factory()->create();
        $this->category = Category::create(['name' => 'Desserts', 'emoji' => '🍰']);
    }

    /**
     * مساعد: ينشأ Dish مع صورة حقيقية على الـ fake disk
     */
    private function createDishWithImage(string $imageName = 'dish.jpg'): Dish
    {
        $fakeImage = UploadedFile::fake()->image($imageName);
        Storage::disk('public')->putFileAs('dishes', $fakeImage, $imageName);

        return Dish::create([
            'name'           => 'Test Dish',
            'description'    => 'A dish for deletion testing',
            'price'          => 100,
            'category_id'    => $this->category->id,
            'time_preparing' => 15,
            'is_available'   => true,
            'image'          => $imageName,
        ]);
    }

    /**
     * مساعد: ينشأ Dish بدون صورة
     */
    private function createDishWithoutImage(): Dish
    {
        return Dish::create([
            'name'           => 'No Image Dish',
            'description'    => 'A dish without an image for testing',
            'price'          => 80,
            'category_id'    => $this->category->id,
            'time_preparing' => 10,
            'is_available'   => true,
            'image'          => '',
        ]);
    }

    // =========================================================================
    // 1) Basic data deletion
    // =========================================================================

    /** @test */
    public function it_deletes_a_dish_successfully(): void
    {
        $dish = $this->createDishWithImage();

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/dishes/{$dish->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('dishes', ['id' => $dish->id]);
    }

    /** @test */
    public function it_returns_404_when_deleting_a_non_existent_dish(): void
    {
        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson('/api/owner/dishes/9999');

        $response->assertStatus(404);
    }

    // =========================================================================
    // 2) Image deletion
    // =========================================================================

    /** @test */
    public function it_deletes_the_dish_image_from_storage_when_dish_is_deleted(): void
    {
        $imageName = 'to-delete.jpg';
        $dish      = $this->createDishWithImage($imageName);

        // تأكيد وجود الصورة قبل الحذف
        Storage::disk('public')->assertExists('dishes/' . $imageName);

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/dishes/{$dish->id}");

        $response->assertStatus(204);

        // الصورة لازم تتمسح من الـ storage
        Storage::disk('public')->assertMissing('dishes/' . $imageName);
    }

    /** @test */
    public function it_deletes_a_dish_without_errors_when_no_image_exists(): void
    {
        $dish = $this->createDishWithoutImage();

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/dishes/{$dish->id}");

        // لازم يمسح عادى حتى لو ماكنش في صورة
        $response->assertStatus(204);
        $this->assertDatabaseMissing('dishes', ['id' => $dish->id]);
    }

    // =========================================================================
    // 3) Authorization
    // =========================================================================

    /** @test */
    public function it_forbids_a_regular_customer_from_deleting_a_dish(): void
    {
        $customer = User::factory()->create();
        $dish     = $this->createDishWithImage();

        $response = $this->actingAs($customer, 'customer')
            ->deleteJson("/api/owner/dishes/{$dish->id}");

        $response->assertStatus(401);

        // الـ dish لازم يفضل موجود
        $this->assertDatabaseHas('dishes', ['id' => $dish->id]);
    }

    /** @test */
    public function only_an_admin_owner_can_delete_a_dish(): void
    {
        $dish = $this->createDishWithImage();

        $response = $this->actingAs($this->admin, 'owner')
            ->deleteJson("/api/owner/dishes/{$dish->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('dishes', ['id' => $dish->id]);
    }
}
