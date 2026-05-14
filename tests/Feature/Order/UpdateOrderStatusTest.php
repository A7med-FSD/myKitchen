<?php

namespace Tests\Feature\Order;

use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DishSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OwnerSeeder;
use App\Models\Admin;
use App\Models\Order;
use App\Events\OrderDelivered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    private Admin $owner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            UserSeeder::class,
            CategorySeeder::class,
            DishSeeder::class,
            OrderSeeder::class,
            OwnerSeeder::class,
        ]);

        $this->owner = Admin::where('email', 'owner@mykitchen.com')->first();
    }

    private function patch2(int $orderId, string $status)
    {
        return $this->actingAs($this->owner, 'owner')
            ->patchJson("/api/owner/orders/{$orderId}", ['status' => $status]);
    }

    // ─── Test 1: pending → in_progress ✅ ────────────────────────────────
    public function test_owner_can_move_order_from_pending_to_in_progress(): void
    {
        $order = Order::where('order_code', '20260509-0001')->first(); // pending by default
        $order->status = 'pending';
        $order->save();

        $response = $this->patch2($order->id, 'in_progress');

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'in_progress',
        ]);
    }

    // ─── Test 2: ready → delivered ✅ + dispatches event ─────────────────
    public function test_owner_can_deliver_order_and_event_is_dispatched(): void
    {
        Event::fake([OrderDelivered::class]);

        $order = Order::where('order_code', '20260509-0001')->first();
        $order->status = 'ready';
        $order->save();

        $response = $this->patch2($order->id, 'delivered');

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'delivered',
        ]);
        Event::assertDispatched(OrderDelivered::class, function ($event) use ($order) {
            return $event->userId === $order->user_id;
        });
    }

    // ─── Test 3: pending → cancelled ✅ ──────────────────────────────────
    public function test_owner_can_cancel_pending_order(): void
    {
        $order = Order::where('order_code', '20260509-0001')->first();
        $order->status = 'pending';
        $order->save();

        $response = $this->patch2($order->id, 'cancelled');

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'cancelled',
        ]);
    }

    // ─── Test 4: delivered → cancelled ❌ (bad update) ───────────────────
    public function test_cannot_cancel_already_delivered_order(): void
    {
        $order = Order::where('order_code', '20260509-0001')->first();
        $order->status = 'delivered';
        $order->save();

        $response = $this->patch2($order->id, 'cancelled');

        $response->assertStatus(422);
        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'delivered', // لم يتغير
        ]);
    }

    // ─── Test 5: pending → delivered ❌ (skip) ───────────────────────────
    public function test_cannot_skip_status_from_pending_to_delivered(): void
    {
        $order = Order::where('order_code', '20260509-0001')->first();
        $order->status = 'pending';
        $order->save();

        $response = $this->patch2($order->id, 'delivered');

        $response->assertStatus(422);
        $this->assertDatabaseHas('orders', [
            'id'     => $order->id,
            'status' => 'pending',
        ]);
    }

    // ─── Test 6: event لا يُرسل إلا عند delivered ───────────────────────
    public function test_event_is_not_dispatched_on_non_delivered_transitions(): void
    {
        Event::fake([OrderDelivered::class]);

        $order = Order::where('order_code', '20260509-0001')->first();
        $order->status = 'pending';
        $order->save();

        $this->patch2($order->id, 'in_progress');

        Event::assertNotDispatched(OrderDelivered::class);
    }
}
