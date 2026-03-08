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

        // جلب كل الـ dishes مرة واحدة
        $grilledChicken   = Dish::where('name', 'Grilled Chicken with Rice')->first();
        $lentilSoup       = Dish::where('name', 'Lentil Soup')->first();
        $chocolateCake    = Dish::where('name', 'Chocolate Lava Cake')->first();
        $mixedGrill       = Dish::where('name', 'Mixed Grill Platter')->first();
        $mangoSmoothie    = Dish::where('name', 'Mango Smoothie')->first();

        // ─── أوردر 1 — Ahmed: Grilled Chicken + Lentil Soup (هذا الأسبوع) ───
        // 📊 Expected:
        //   Grilled Chicken → dish_total_price = 85 × (1 - 20/100) × 3 = 204
        //   Lentil Soup     → dish_total_price = 35 × (1 - 10/100) × 1 = 31.5
        //   order total_price = 204 + 31.5 = 235.5
        $order1 = Order::create([
            'user_id'        => $ahmed->id,
            'customer_name'  => 'Ahmed Ali',
            'customer_phone' => '01001234567',
            'status'         => 'delivered',
            'order_code'     => "1001",
            'total_price'    => 120,
            'payment_method' => 'cash',
        ]);
        $order1->created_at = now()->subDays(3); // 2026-03-05 ✅ هذا الأسبوع
        $order1->save();
        $order1->dishes()->attach($grilledChicken->id, [
            'quantity'            => 3,
            'dish_price_at_order' => $grilledChicken->price,
            'dish_name_at_order'  => $grilledChicken->name,
            'promotion_value'     => 20,
        ]);
        $order1->dishes()->attach($lentilSoup->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $lentilSoup->price,
            'dish_name_at_order'  => $lentilSoup->name,
            'promotion_value'     => 10,
        ]);

        // ─── أوردر 2 — Ahmed: Grilled Chicken + Chocolate Lava Cake (هذا الشهر) ───
        // 📊 Expected:
        //   Grilled Chicken    → dish_total_price = 85 × 1 (no promo) × 1 = 85
        //   Chocolate Lava Cake→ dish_total_price = 50 × (1 - 10/100) × 1 = 45
        //   order total_price = 85 + 45 = 130
        $order2 = Order::create([
            'user_id'        => $ahmed->id,
            'customer_name'  => 'Ahmed Ali',
            'customer_phone' => '01001234567',
            'status'         => 'delivered',
            'order_code'     => "1002",
            'total_price'    => 135,
            'payment_method' => 'cash',
        ]);
        $order2->created_at = now()->subDays(20); // 2026-02-17 ✅ هذا الشهر (last 30 days)
        $order2->save();
        $order2->dishes()->attach($grilledChicken->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $grilledChicken->price,
            'dish_name_at_order'  => $grilledChicken->name,
            'promotion_value'     => null,
        ]);
        $order2->dishes()->attach($chocolateCake->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $chocolateCake->price,
            'dish_name_at_order'  => $chocolateCake->name,
            'promotion_value'     => 10,
        ]);

        // ─── أوردر 3 — Ahmed: Mixed Grill Platter (هذه السنة) ───
        // 📊 Expected:
        //   Mixed Grill Platter → dish_total_price = 145 × 1 (no promo) × 1 = 145
        //   order total_price = 145
        $order3 = Order::create([
            'user_id'        => $ahmed->id,
            'customer_name'  => 'Ahmed Ali',
            'customer_phone' => '01001234567',
            'status'         => 'delivered',
            'order_code'     => "1003",
            'total_price'    => 145,
            'payment_method' => 'card',
        ]);
        $order3->created_at = now()->subMonths(6); // 2025-09-08 ✅ هذه السنة (last 365 days)
        $order3->save();
        $order3->dishes()->attach($mixedGrill->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $mixedGrill->price,
            'dish_name_at_order'  => $mixedGrill->name,
            'promotion_value'     => null,
        ]);

        // ─── أوردر 7 — Ahmed: Chocolate Lava Cake (أقدم من سنة) ───
        $order7 = Order::create([
            'user_id'        => $ahmed->id,
            'customer_name'  => 'Ahmed Ali',
            'customer_phone' => '01001234567',
            'status'         => 'delivered',
            'order_code'     => "1007",
            'total_price'    => 50,
            'payment_method' => 'cash',
        ]);
        $order7->created_at = now()->subMonths(18); // 2024-09-08 ✅ أقدم من سنة
        $order7->save();
        $order7->dishes()->attach($chocolateCake->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $chocolateCake->price,
            'dish_name_at_order'  => $chocolateCake->name,
            'promotion_value'     => null,
        ]);

        // ─── أوردر 4 — Sara: Chocolate Lava Cake + Mango Smoothie ───
        // 📊 Expected:
        //   Chocolate Lava Cake → dish_total_price = 50 × 1 (no promo) × 1 = 50
        //   Mango Smoothie      → dish_total_price = 35 × 1 (no promo) × 1 = 35
        //   order total_price = 50 + 35 = 85
        $order4 = Order::create([
            'user_id'        => $sara->id,
            'customer_name'  => 'Sara Mohamed',
            'customer_phone' => '01009876543',
            'status'         => 'delivered',
            'order_code'     => "1004",
            'total_price'    => 85,
            'payment_method' => 'cash',
        ]);
        $order4->dishes()->attach($chocolateCake->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $chocolateCake->price,
            'dish_name_at_order'  => $chocolateCake->name,
            'promotion_value'     => null,
        ]);
        $order4->dishes()->attach($mangoSmoothie->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $mangoSmoothie->price,
            'dish_name_at_order'  => $mangoSmoothie->name,
            'promotion_value'     => null,
        ]);

        // ─── أوردر 5 — Sara: Grilled Chicken + Mixed Grill ───
        // 📊 Expected:
        //   Grilled Chicken     → dish_total_price = 85 × 1 (no promo) × 1 = 85
        //   Mixed Grill Platter → dish_total_price = 145 × 1 (no promo) × 1 = 145
        //   order total_price = 85 + 145 = 230
        $order5 = Order::create([
            'user_id'        => $sara->id,
            'customer_name'  => 'Sara Mohamed',
            'customer_phone' => '01009876543',
            'status'         => 'in_progress',
            'order_code'     => "1005",
            'total_price'    => 230,
            'payment_method' => 'cash',
        ]);
        $order5->dishes()->attach($grilledChicken->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $grilledChicken->price,
            'dish_name_at_order'  => $grilledChicken->name,
            'promotion_value'     => null,
        ]);
        $order5->dishes()->attach($mixedGrill->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $mixedGrill->price,
            'dish_name_at_order'  => $mixedGrill->name,
            'promotion_value'     => null,
        ]);

        // ─── أوردر 6 — Sara: Chocolate Lava Cake ───
        // 📊 Expected:
        //   Chocolate Lava Cake → dish_total_price = 50 × 1 (no promo) × 1 = 50
        //   order total_price = 50
        $order6 = Order::create([
            'user_id'        => $sara->id,
            'customer_name'  => 'Sara Mohamed',
            'customer_phone' => '01009876543',
            'status'         => 'delivered',
            'order_code'     => "1006",
            'total_price'    => 50,
            'payment_method' => 'card',
        ]);
        $order6->dishes()->attach($chocolateCake->id, [
            'quantity'            => 1,
            'dish_price_at_order' => $chocolateCake->price,
            'dish_name_at_order'  => $chocolateCake->name,
            'promotion_value'     => null,
        ]);
    }
}
