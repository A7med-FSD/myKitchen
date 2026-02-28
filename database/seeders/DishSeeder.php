<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    public function run(): void
    {
        // يجب تشغيل CategorySeeder أولاً
        $mainDishes  = Category::where('name', 'Main Dishes')->first()->id;
        $grills      = Category::where('name', 'Grills')->first()->id;
        $sandwiches  = Category::where('name', 'Sandwiches')->first()->id;
        $pastries    = Category::where('name', 'Pastries')->first()->id;
        $salads      = Category::where('name', 'Salads')->first()->id;
        $soups       = Category::where('name', 'Soups')->first()->id;
        $desserts    = Category::where('name', 'Desserts')->first()->id;
        $drinks      = Category::where('name', 'Drinks')->first()->id;

        $dishes = [
            // Main Dishes
            [
                'name'           => 'Grilled Chicken with Rice',
                'description'    => 'Tender grilled chicken breast served on a bed of seasoned rice with grilled vegetables.',
                'price'          => 85,
                'time_preparing' => 25,
                'badge'          => 'featured',
                'rate'           => 4.8,
                'is_available'   => true,
                'category_id'    => $mainDishes,
                'image'          => "image test",
            ],
            [
                'name'           => 'Pasta Bolognese',
                'description'    => 'Classic Italian pasta with slow-cooked beef bolognese sauce and parmesan.',
                'price'          => 70,
                'time_preparing' => 20,
                'badge'          => null,
                'rate'           => 4.5,
                'is_available'   => true,
                'category_id'    => $mainDishes,
                'image'          => "image test",
            ],

            // Grills
            [
                'name'           => 'Mixed Grill Platter',
                'description'    => 'A generous platter of grilled kofta, chicken, and lamb chops with pita bread.',
                'price'          => 145,
                'time_preparing' => 35,
                'badge'          => 'special',
                'rate'           => 4.9,
                'is_available'   => true,
                'category_id'    => $grills,
                'image'          => "image test",
            ],
            [
                'name'           => 'Beef Kofta',
                'description'    => 'Juicy spiced beef kofta on skewers, served with tahini sauce and salad.',
                'price'          => 90,
                'time_preparing' => 20,
                'badge'          => null,
                'rate'           => 4.6,
                'is_available'   => true,
                'category_id'    => $grills,
                'image'          => "image test",
            ],

            // Sandwiches
            [
                'name'           => 'Crispy Chicken Sandwich',
                'description'    => 'Crispy fried chicken fillet with pickles, lettuce, and special sauce in a brioche bun.',
                'price'          => 55,
                'time_preparing' => 15,
                'badge'          => 'new',
                'rate'           => 4.7,
                'is_available'   => true,
                'category_id'    => $sandwiches,
                'image'          => "image test",
            ],
            [
                'name'           => 'Club Sandwich',
                'description'    => 'Triple-decker sandwich with turkey, bacon, egg, lettuce, and tomato.',
                'price'          => 65,
                'time_preparing' => 10,
                'badge'          => null,
                'rate'           => 4.3,
                'is_available'   => true,
                'category_id'    => $sandwiches,
                'image'          => "image test",
            ],

            // Pastries
            [
                'name'           => 'Cheese Croissant',
                'description'    => 'Flaky buttery croissant filled with melted cheddar cheese.',
                'price'          => 30,
                'time_preparing' => 10,
                'badge'          => 'recommended',
                'rate'           => 4.4,
                'is_available'   => true,
                'category_id'    => $pastries,
                'image'          => "image test",
            ],

            // Salads
            [
                'name'           => 'Caesar Salad',
                'description'    => 'Crisp romaine lettuce, croutons, and parmesan with classic Caesar dressing.',
                'price'          => 45,
                'time_preparing' => 10,
                'badge'          => null,
                'rate'           => 4.2,
                'is_available'   => true,
                'category_id'    => $salads,
                'image'          => "image test",
            ],

            // Soups
            [
                'name'           => 'Lentil Soup',
                'description'    => 'Hearty Egyptian-style red lentil soup with cumin and a squeeze of lemon.',
                'price'          => 35,
                'time_preparing' => 15,
                'badge'          => null,
                'rate'           => 4.5,
                'is_available'   => true,
                'category_id'    => $soups,
                'image'          => "image test",
            ],

            // Desserts
            [
                'name'           => 'Chocolate Lava Cake',
                'description'    => 'Warm chocolate cake with a gooey molten center, served with vanilla ice cream.',
                'price'          => 50,
                'time_preparing' => 15,
                'badge'          => 'featured',
                'rate'           => 4.9,
                'is_available'   => true,
                'category_id'    => $desserts,
                'image'          => "image test",
            ],
            [
                'name'           => 'Umm Ali',
                'description'    => 'Traditional Egyptian pastry dessert with milk, nuts, and cream.',
                'price'          => 40,
                'time_preparing' => 20,
                'badge'          => null,
                'rate'           => 4.7,
                'is_available'   => true,
                'category_id'    => $desserts,
                'image'          => "image test",
            ],

            // Drinks
            [
                'name'           => 'Fresh Orange Juice',
                'description'    => 'Freshly squeezed orange juice, served chilled.',
                'price'          => 25,
                'time_preparing' => 5,
                'badge'          => null,
                'rate'           => 4.6,
                'is_available'   => true,
                'category_id'    => $drinks,
                'image'          => "image test",
            ],
            [
                'name'           => 'Mango Smoothie',
                'description'    => 'Thick and creamy mango smoothie made with fresh mangoes and milk.',
                'price'          => 35,
                'time_preparing' => 5,
                'badge'          => 'new',
                'rate'           => 4.8,
                'is_available'   => true,
                'category_id'    => $drinks,
                'image'          => "image test",
            ],
        ];

        foreach ($dishes as $dish) {
            Dish::create($dish);
        }
    }
}
