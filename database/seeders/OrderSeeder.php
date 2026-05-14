<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $ahmed = User::where('email', 'ahmed@example.com')->first();
        $sara  = User::where('email', 'sara@example.com')->first();

        $grilledChicken = Dish::where('name', 'Grilled Chicken with Rice')->first();
        $lentilSoup     = Dish::where('name', 'Lentil Soup')->first();
        $chocolateCake  = Dish::where('name', 'Chocolate Lava Cake')->first();
        $mixedGrill     = Dish::where('name', 'Mixed Grill Platter')->first();
        $mangoSmoothie  = Dish::where('name', 'Mango Smoothie')->first();

        // ─── أوردر 1 — Ahmed (هذا الأسبوع) + promotion_value 10% على الأوردر ───
        // 📊 Expected:
        //   Grilled Chicken → (85 × 80%) × 3 = 204
        //   Lentil Soup     → (35 × 90%) × 1 = 31.5
        //   subtotal dishes = 235.5
        //   order promotion 10% → 235.5 × 90% = 211.95  ← total_price النهائي
        Order::unguarded(function () use ($ahmed, $grilledChicken, $lentilSoup) {
            $order = Order::create([
                'user_id'         => $ahmed->id,
                'customer_name'   => 'Ahmed Ali',
                'customer_phone'  => '01001234567',
                'status'          => 'delivered',
                'order_code'      => '20260509-0001',
                'address_text'    => '123 Nile St, Cairo',
                'payment_method'  => 'visa',
                'promotion_value' => 10,
                'created_at'      => now()->subDays(3), 
            ]);
            $order->dishes()->attach($grilledChicken->id, [
                'quantity'            => 3,
                'dish_price_at_order' => $grilledChicken->price,
                'dish_name_at_order'  => $grilledChicken->name,
                'promotion_value'     => 20,
            ]);
            $order->dishes()->attach($lentilSoup->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $lentilSoup->price,
                'dish_name_at_order'  => $lentilSoup->name,
                'promotion_value'     => 10,
            ]);
        });

        // ─── أوردر 2 — Ahmed (هذا الشهر) ───
        // 📊 Expected:
        //   Grilled Chicken     → 85 × 1     = 85
        //   Chocolate Lava Cake → (50×90%)×1 = 45
        //   order total = 130 (لا يوجد promotion على الأوردر)
        Order::unguarded(function () use ($ahmed, $grilledChicken, $chocolateCake) {
            $order = Order::create([
                'user_id'        => $ahmed->id,
                'customer_name'  => 'Ahmed Ali',
                'customer_phone' => '01001234567',
                'status'         => 'delivered',
                'order_code'     => '20260509-0002',
                'address_text'   => '123 Nile St, Cairo',
                'payment_method' => 'vodafone',
                'created_at'     => now()->subDays(20), // ✅ هذا الشهر (last 30 days)
            ]);
            $order->dishes()->attach($grilledChicken->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $grilledChicken->price,
                'dish_name_at_order'  => $grilledChicken->name,
                'promotion_value'     => null,
            ]);
            $order->dishes()->attach($chocolateCake->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $chocolateCake->price,
                'dish_name_at_order'  => $chocolateCake->name,
                'promotion_value'     => 10,
            ]);
        });

        // ─── أوردر 3 — Ahmed (هذه السنة) ───
        // 📊 Expected:
        //   Mixed Grill Platter → 145 × 1 = 145
        Order::unguarded(function () use ($ahmed, $mixedGrill) {
            $order = Order::create([
                'user_id'        => $ahmed->id,
                'customer_name'  => 'Ahmed Ali',
                'customer_phone' => '01001234567',
                'status'         => 'delivered',
                'order_code'     => '20260509-0003',
                'address_text'   => '123 Nile St, Cairo',
                'payment_method' => 'instaPay',
                'created_at'     => now()->subMonths(6), // ✅ هذه السنة (last 365 days)
            ]);
            $order->dishes()->attach($mixedGrill->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $mixedGrill->price,
                'dish_name_at_order'  => $mixedGrill->name,
                'promotion_value'     => null,
            ]);
        });

        // ─── أوردر 7 — Ahmed (أقدم من سنة) ───
        // 📊 Expected:
        //   Chocolate Lava Cake → 50 × 1 = 50
        Order::unguarded(function () use ($ahmed, $chocolateCake) {
            $order = Order::create([
                'user_id'        => $ahmed->id,
                'customer_name'  => 'Ahmed Ali',
                'customer_phone' => '01001234567',
                'status'         => 'delivered',
                'order_code'     => '20260509-0007',
                'address_text'   => '123 Nile St, Cairo',
                'payment_method' => 'fawry',
                'created_at'     => now()->subMonths(18), // ✅ أقدم من سنة
            ]);
            $order->dishes()->attach($chocolateCake->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $chocolateCake->price,
                'dish_name_at_order'  => $chocolateCake->name,
                'promotion_value'     => null,
            ]);
        });

        // ─── أوردر 4 — Sara ───
        // 📊 Expected:
        //   Chocolate Lava Cake → 50 × 1 = 50
        //   Mango Smoothie      → 35 × 1 = 35
        //   order total = 85
        Order::unguarded(function () use ($sara, $chocolateCake, $mangoSmoothie) {
            $order = Order::create([
                'user_id'        => $sara->id,
                'customer_name'  => 'Sara Mohamed',
                'customer_phone' => '01009876543',
                'status'         => 'delivered',
                'order_code'     => '20260509-0004',
                'address_text'   => '45 Pyramids Rd, Giza',
                'payment_method' => 'visa',
            ]);
            $order->dishes()->attach($chocolateCake->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $chocolateCake->price, 
                'dish_name_at_order'  => $chocolateCake->name, // desserts
                'promotion_value'     => null,
            ]);
            $order->dishes()->attach($mangoSmoothie->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $mangoSmoothie->price, 
                'dish_name_at_order'  => $mangoSmoothie->name, // drinks
                'promotion_value'     => null,
            ]);
        });

        // ─── أوردر 5 — Sara ───
        // 📊 Expected:
        //   Grilled Chicken     → 85 × 1  = 85
        //   Mixed Grill Platter → 145 × 1 = 145
        //   order total = 230
        Order::unguarded(function () use ($sara, $grilledChicken, $mixedGrill) {
            $order = Order::create([
                'user_id'        => $sara->id,
                'customer_name'  => 'Sara Mohamed',
                'customer_phone' => '01009876543',
                'status'         => 'in_progress',
                'order_code'     => '20260509-0005',
                'address_text'   => '45 Pyramids Rd, Giza',
                'payment_method' => 'vodafone',
            ]);
            $order->dishes()->attach($grilledChicken->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $grilledChicken->price, // mainDishes
                'dish_name_at_order'  => $grilledChicken->name,
                'promotion_value'     => null,
            ]);
            $order->dishes()->attach($mixedGrill->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $mixedGrill->price, // mainDishes
                'dish_name_at_order'  => $mixedGrill->name,
                'promotion_value'     => null,
            ]);
        });

        // ─── أوردر 6 — Sara ───
        // 📊 Expected:
        //   Chocolate Lava Cake → 50 × 1 = 50
        Order::unguarded(function () use ($sara, $chocolateCake) {
            $order = Order::create([
                'user_id'        => $sara->id,
                'customer_name'  => 'Sara Mohamed',
                'customer_phone' => '01009876543',
                'status'         => 'delivered',
                'order_code'     => '20260509-0006',
                'address_text'   => '45 Pyramids Rd, Giza',
                'payment_method' => 'instaPay',
            ]);
            $order->dishes()->attach($chocolateCake->id, [
                'quantity'            => 1,
                'dish_price_at_order' => $chocolateCake->price,
                'dish_name_at_order'  => $chocolateCake->name, // desserts
                'promotion_value'     => null,
            ]);
        });
    }
}
