<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Promotion 1: خصم 20% على الـ Grilled Chicken (نشط حالياً) ───
        $promo1 = Promotion::create([
            'title'       => 'Grilled Chicken Deal',
            'promo_code'  => 'GRILL20',
            'apply_to'    => 'dishes',
            'value'       => 20,
            'start_date'  => now()->subDays(2),
            'end_date'    => now()->addDays(5),
            'is_active'   => true,
            'count_usage' => 0,
        ]);

        $promo1->dishes()->attach(
            Dish::where('name', 'Grilled Chicken with Rice')->first()?->id
        );

        // ─── Promotion 2: خصم 15% على الـ Desserts dishes (نشط) ───
        $promo2 = Promotion::create([
            'title'       => 'Sweet Treats Offer',
            'promo_code'  => 'SWEET15',
            'apply_to'    => 'dishes',
            'value'       => 15,
            'start_date'  => now()->subDay(),
            'end_date'    => now()->addDays(10),
            'is_active'   => true,
            'count_usage' => 0,
        ]);

        $promo2->dishes()->attach(
            Dish::whereIn('name', ['Chocolate Lava Cake', 'Umm Ali'])->pluck('id')
        );

        // ─── Promotion 3: خصم 25% على الـ Mixed Grill (نشط) ───
        $promo3 = Promotion::create([
            'title'       => 'Grill Night Special',
            'promo_code'  => null,          // بدون كود — تطبق تلقائي
            'apply_to'    => 'dishes',
            'value'       => 25,
            'start_date'  => now(),
            'end_date'    => now()->addDays(3),
            'is_active'   => true,
            'count_usage' => 0,
        ]);

        $promo3->dishes()->attach(
            Dish::where('name', 'Mixed Grill Platter')->first()?->id
        );

        // ─── Promotion 4: خصم منتهي (للتست إن الـ inactive مش بيتعرض) ───
        $promo4 = Promotion::create([
            'title'       => 'Old Summer Offer',
            'promo_code'  => 'SUMMER10',
            'apply_to'    => 'dishes',
            'value'       => 10,
            'start_date'  => now()->subDays(30),
            'end_date'    => now()->subDays(1),  // انتهى امبارح
            'is_active'   => false,
            'count_usage' => 45,
        ]);

        $promo4->dishes()->attach(
            Dish::where('name', 'Mango Smoothie')->first()?->id
        );

        Promotion::create([
            'title'       => 'All Menu Deal',
            'promo_code'  => 'MENU15',
            'apply_to'    => 'all_menu',
            'value'       => 15,
            'start_date'  => now()->subDay(),
            'end_date'    => now()->addDays(7),
            'is_active'   => true,
            'count_usage' => 0,
        ]);
    }
}
