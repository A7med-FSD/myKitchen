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
            'apply_to'    => 'dishes',
            'value'       => 5,
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

        // ─── Promotion 5: all_menu بـ promo_code (موجود من قبل) ───
        // promo_code=MENU15 | value=15% | automatic=false ✅
        Promotion::create([
            'title'       => 'All Menu Deal',
            'promo_code'  => 'MENU15',           // ✅ all_menu له promo_code
            'apply_to'    => 'all_menu',
            'value'       => 15,
            'start_date'  => now()->subDay(),
            'end_date'    => now()->addDays(7),
            'is_active'   => true,
            'count_usage' => 0,
        ]);

        // ─── Promotion 6: categories — automatic (بدون promo_code) ───
        // 📊 Expected: خصم 10% على كل الـ dishes في Desserts و Drinks تلقائياً
        $promo6 = Promotion::create([
            'title'       => 'Drinks & Desserts Weekend',
            'promo_code'  => null,               // ✅ categories = automatic
            'apply_to'    => 'categories',
            'value'       => 10,
            'start_date'  => now()->subDays(1),
            'end_date'    => now()->addDays(4),
            'is_active'   => true,
            'count_usage' => 0,
        ]);

        $promo6->categories()->attach(
            \App\Models\Category::whereIn('name', ['Desserts', 'Drinks'])->pluck('id')
        );

        // ─── Promotion 7: special بـ promo_code ───
        // 📊 Expected: خصم VIP 30% — يتبعت مع promo_code=VIP30
        Promotion::create([
            'title'       => 'VIP Special Offer',
            'promo_code'  => 'VIP30',            // ✅ special له promo_code
            'apply_to'    => 'special',
            'value'       => 30,
            'start_date'  => now()->addDays(2),
            'end_date'    => now()->addDays(14),
            'is_active'   => true,
            'count_usage' => 0,
        ]);

        // ─── Promotion 8: all_menu منتهية (للتست إن الـ expired مش بيتعرض) ───
        Promotion::create([
            'title'       => 'Old All Menu Offer',
            'promo_code'  => 'OLD20',
            'apply_to'    => 'all_menu',
            'value'       => 20,
            'start_date'  => now()->subDays(20),
            'end_date'    => now()->subDays(1),  // انتهت امبارح
            'is_active'   => false,
            'count_usage' => 12,
        ]);
    }
}
