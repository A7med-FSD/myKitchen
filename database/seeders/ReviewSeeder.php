<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |-----------------------------------------------------------------------
        | الترتيب المتوقع في الـ API (orderBy created_at DESC, then id ASC):
        |-----------------------------------------------------------------------
        | Page 1:
        |   1. Lentil Soup          — Sara    — 2026-04-09  (id=7, أحدث published)
        |   2. Pasta Bolognese      — Sara    — 2026-04-07  (id=6)
        |   3. Chocolate Lava Cake  — Ahmed   — 2026-04-05  (id=5)
        | Page 2:
        |   4. Crispy Chicken Sand. — Sara    — 2026-04-03  (id=4)
        |   5. Mixed Grill Platter  — Ahmed   — 2026-04-01  (id=3)
        |   6. Grilled Chicken #2   — Sara    — 2026-03-28  (id=2)
        | Page 3:
        |   7. Grilled Chicken #1   — Ahmed   — 2026-03-25  (id=1, أقدم published)
        |-----------------------------------------------------------------------
        | الـ unpublished (id=8,9,10) ما يظهروش خالص
        |-----------------------------------------------------------------------
        */

        $reviews = [
            // ============ Published (يظهر في الـ API) ============

            // id=1 — أقدم review
            [
                'user_id'      => 1, // Ahmed
                'dish_id'      => 1, // Grilled Chicken with Rice
                'rating'       => 5,
                'content'      => 'Amazing dish! The chicken was perfectly grilled and the rice was so flavorful.',
                'is_published' => true,
                'created_at'   => '2026-03-25 10:00:00',
            ],
            // id=2
            [
                'user_id'      => 2, // Sara
                'dish_id'      => 1, // Grilled Chicken with Rice
                'rating'       => 4,
                'content'      => 'Really good, will definitely order again. Loved the seasoning on the rice.',
                'is_published' => true,
                'created_at'   => '2026-03-28 14:30:00',
            ],
            // id=3
            [
                'user_id'      => 1, // Ahmed
                'dish_id'      => 3, // Mixed Grill Platter
                'rating'       => 5,
                'content'      => 'Best mixed grill I have ever had! The kofta was juicy and full of flavor.',
                'is_published' => true,
                'created_at'   => '2026-04-01 09:15:00',
            ],
            // id=4
            [
                'user_id'      => 2, // Sara
                'dish_id'      => 5, // Crispy Chicken Sandwich
                'rating'       => 5,
                'content'      => 'Crispy, tasty, and the special sauce is a game changer. Highly recommended!',
                'is_published' => true,
                'created_at'   => '2026-04-03 12:00:00',
            ],
            // id=5
            [
                'user_id'      => 1, // Ahmed
                'dish_id'      => 10, // Chocolate Lava Cake
                'rating'       => 5,
                'content'      => 'Absolutely divine! The molten center was perfect and the ice cream pairing was spot on.',
                'is_published' => true,
                'created_at'   => '2026-04-05 20:00:00',
            ],
            // id=6
            [
                'user_id'      => 2, // Sara
                'dish_id'      => 2, // Pasta Bolognese
                'rating'       => 4,
                'content'      => 'Great pasta! Very close to the real Italian taste. Would love a bit more sauce.',
                'is_published' => true,
                'created_at'   => '2026-04-07 11:45:00',
            ],
            // id=7 — أحدث published review
            [
                'user_id'      => 1, // Ahmed
                'dish_id'      => 9, // Lentil Soup
                'rating'       => 4,
                'content'      => 'Comforting and warm. Exactly what I needed. The cumin touch is perfect.',
                'is_published' => true,
                'created_at'   => '2026-04-09 08:30:00',
            ],

            // ============ Unpublished (ما يظهروش في الـ API) ============

            // id=8
            [
                'user_id'      => 2,
                'dish_id'      => 7, // Cheese Croissant
                'rating'       => 3,
                'content'      => 'Good but not as crispy as I expected. Maybe it was sitting for a while.',
                'is_published' => false,
                'created_at'   => '2026-04-06 09:00:00',
            ],
            // id=9
            [
                'user_id'      => 1,
                'dish_id'      => 11, // Umm Ali
                'rating'       => 5,
                'content'      => 'Tastes exactly like home! The nuts and cream make it absolutely perfect.',
                'is_published' => false,
                'created_at'   => '2026-04-08 16:00:00',
            ],
            // id=10
            [
                'user_id'      => 2,
                'dish_id'      => 13, // Mango Smoothie
                'rating'       => 4,
                'content'      => 'Very thick and creamy. Fresh mango taste was great. Could be a bit colder.',
                'is_published' => false,
                'created_at'   => '2026-04-10 07:00:00',
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}

