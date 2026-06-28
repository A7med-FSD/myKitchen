<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->customer = User::factory()->create([
            'name'  => 'Original Name',
            'phone' => '01011111111',
            'image' => null,
        ]);
    }

    // =========================================================================
    // 1) Authorization
    // =========================================================================

    /** @test */
    public function unauthenticated_user_cannot_update_profile(): void
    {
        $response = $this->patchJson('/api/user/profile', ['name' => 'New Name']);

        $response->assertStatus(401);
    }

    // =========================================================================
    // 2) Basic text fields update
    // =========================================================================

    /** @test */
    public function customer_can_update_their_name(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['name' => 'Updated Name']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $this->customer->id, 'name' => 'Updated Name']);
    }

    // =========================================================================
    // 3) Image upload — happy path
    // =========================================================================

    /** @test */
    public function customer_can_upload_a_profile_image(): void
    {
        $image = UploadedFile::fake()->image('avatar.jpg', 100, 100);

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['image' => $image]);

        $response->assertStatus(200);

        // الـ image name المفروض يتحفظ في الـ DB
        $this->customer->refresh();
        $this->assertNotNull($this->customer->image);
        $this->assertStringStartsWith($this->customer->id . '_', $this->customer->image);


        // الـ file المفروض يتحفظ فعلاً على الـ disk
        Storage::disk('public')->assertExists('users/' . $this->customer->image);
    }

    // =========================================================================
    // 4) Old image is deleted when a new one is uploaded
    // =========================================================================

    /** @test */
    public function uploading_new_image_deletes_the_old_one_from_storage(): void
    {
        // نحط صورة قديمة على الـ disk يدوياً
        $oldImageName = $this->customer->id . '_oldimage.jpg';
        Storage::disk('public')->put('users/' . $oldImageName, 'fake-image-content');

        // نحدّث الـ DB بالاسم القديم
        $this->customer->update(['image' => $oldImageName]);

        Storage::disk('public')->assertExists('users/' . $oldImageName);

        // نرفع صورة جديدة
        $newImage = UploadedFile::fake()->image('new_avatar.jpg', 100, 100);

        $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['image' => $newImage]);
        $this->customer->refresh();

        // الصورة القديمة المفروض تتمسح
        Storage::disk('public')->assertMissing('users/' . $oldImageName);
        Storage::disk('public')->assertExists('users/' . $this->customer->image);
    }

    /** @test */
    public function uploading_new_image_when_no_old_image_exists_works_fine(): void
    {
        // مش فيه صورة قديمة (image = null بالـ setUp)
        $this->assertNull($this->customer->image);

        $newImage = UploadedFile::fake()->image('first_time.jpg', 100, 100);

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['image' => $newImage]);

        $response->assertStatus(200);
        $this->customer->refresh();
        $this->assertNotNull($this->customer->image);
        Storage::disk('public')->assertExists('users/' . $this->customer->image);
    }

    // =========================================================================
    // 5) Image validation — failure cases
    // =========================================================================

    /** @test */
    public function image_upload_fails_when_file_is_not_an_image(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['image' => $file]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }

    /** @test */
    public function image_upload_fails_when_file_exceeds_2mb(): void
    {
        // 2049 KB > 2048 KB (الـ max)
        $largeImage = UploadedFile::fake()->image('big.jpg')->size(2049);

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['image' => $largeImage]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }

    /** @test */
    public function image_field_is_optional_and_can_be_skipped(): void
    {
        // بنعمل update بدون image — المفروض يمشي عادي
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['name' => 'No Image Update']);

        $response->assertStatus(200);
        // الـ image مش المفروض تتأثر
        $this->customer->refresh();
        $this->assertNull($this->customer->image);
    }

    /** @test */
    public function old_image_is_not_deleted_when_no_new_image_is_uploaded(): void
    {
        $oldImageName = $this->customer->id . '_kept.jpg';
        Storage::disk('public')->put('users/' . $oldImageName, 'content');
        $this->customer->update(['image' => $oldImageName]);

        // نعمل update على الاسم بس — من غير image
        $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['name' => 'Name Only Update']);

        // الصورة القديمة المفروض تفضل موجودة
        Storage::disk('public')->assertExists('users/' . $oldImageName);
    }

    // =========================================================================
    // 6) Name validation
    // =========================================================================

    /** @test */
    public function name_must_be_at_least_3_characters(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['name' => 'AB']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    // =========================================================================
    // 7) Email validation
    // =========================================================================

    /** @test */
    public function customer_can_update_with_their_own_email(): void
    {
        $this->customer->update(['email' => 'mine@example.com']);

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['email' => 'mine@example.com']);

        $response->assertStatus(200);
    }

    /** @test */
    public function email_must_be_valid_format(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['email' => 'not-an-email']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function email_must_be_unique_across_users(): void
    {
        $otherUser = User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['email' => 'taken@example.com']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    // =========================================================================
    // 8) Phone validation
    // =========================================================================

    /** @test */
    public function customer_can_update_with_their_own_phone(): void
    {
        $this->customer->update(['phone' => '01011111111']);

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['phone' => '01011111111']);

        $response->assertStatus(200);
    }

    /** @test */
    public function phone_must_be_unique_across_users(): void
    {
        User::factory()->create(['phone' => '01099999999']);

        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', ['phone' => '01099999999']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phone']);
    }

    // =========================================================================
    // 9) Latitude / Longitude — required_with each other
    // =========================================================================

    /** @test */
    public function it_fails_if_latitude_is_sent_without_longitude(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', [
                'latitude' => 30.0444
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['longitude']);
    }

    /** @test */
    public function it_fails_if_longitude_is_sent_without_latitude(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', [
                'longitude' => 31.2357
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['latitude']);
    }

    /** @test */
    public function it_passes_if_both_coordinates_are_missing(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', [
                'name' => 'Ahmed Mohamed' 
            ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function customer_can_update_location_when_both_coordinates_are_provided(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', [
                'latitude'  => 30.0444,
                'longitude' => 31.2357,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id'        => $this->customer->id,
            'latitude'  => 30.04440000,
            'longitude' => 31.23570000,
        ]);
    }

    /** @test */
    public function latitude_must_be_between_minus_90_and_90(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', [
                'latitude'  => 91.0,
                'longitude' => 31.2357,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['latitude']);
    }

    /** @test */
    public function longitude_must_be_between_minus_180_and_180(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->patchJson('/api/user/profile', [
                'latitude'  => 30.0444,
                'longitude' => 181.0,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['longitude']);
    }
}
