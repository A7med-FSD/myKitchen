<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            // Dairy
            ['name' => 'Milk',              'category' => 'Dairy',      'quantity' => 5,  'unit' => 'L',   'price_per_unit' => 1.50,  'low_stock_alert' => 10],
            ['name' => 'Butter',            'category' => 'Dairy',      'quantity' => 20,  'unit' => 'kg',  'price_per_unit' => 8.00,  'low_stock_alert' => 5],
            ['name' => 'Cheddar Cheese',    'category' => 'Dairy',      'quantity' => 15,  'unit' => 'kg',  'price_per_unit' => 12.00, 'low_stock_alert' => 3],
            ['name' => 'Heavy Cream',       'category' => 'Dairy',      'quantity' => 30,  'unit' => 'L',   'price_per_unit' => 3.00,  'low_stock_alert' => 5],
            ['name' => 'Yogurt',            'category' => 'Dairy',      'quantity' => 0,  'unit' => 'kg',  'price_per_unit' => 2.50,  'low_stock_alert' => 5],

            // Meat & Poultry
            ['name' => 'Chicken Breast',    'category' => 'Meat',       'quantity' => 40,  'unit' => 'kg',  'price_per_unit' => 7.00,  'low_stock_alert' => 8],
            ['name' => 'Ground Beef',       'category' => 'Meat',       'quantity' => 30,  'unit' => 'kg',  'price_per_unit' => 9.50,  'low_stock_alert' => 8],
            ['name' => 'Lamb Chops',        'category' => 'Meat',       'quantity' => 20,  'unit' => 'kg',  'price_per_unit' => 18.00, 'low_stock_alert' => 5],
            ['name' => 'Beef Steak',        'category' => 'Meat',       'quantity' => 15,  'unit' => 'kg',  'price_per_unit' => 22.00, 'low_stock_alert' => 4],
            ['name' => 'Shrimp',            'category' => 'Meat',       'quantity' => 10,  'unit' => 'kg',  'price_per_unit' => 25.00, 'low_stock_alert' => 3],

            // Vegetables
            ['name' => 'Tomatoes',          'category' => 'Vegetables', 'quantity' => 60,  'unit' => 'kg',  'price_per_unit' => 1.20,  'low_stock_alert' => 10],
            ['name' => 'Onions',            'category' => 'Vegetables', 'quantity' => 50,  'unit' => 'kg',  'price_per_unit' => 0.80,  'low_stock_alert' => 10],
            ['name' => 'Garlic',            'category' => 'Vegetables', 'quantity' => 10,  'unit' => 'kg',  'price_per_unit' => 3.50,  'low_stock_alert' => 3],
            ['name' => 'Bell Peppers',      'category' => 'Vegetables', 'quantity' => 30,  'unit' => 'kg',  'price_per_unit' => 2.00,  'low_stock_alert' => 5],
            ['name' => 'Spinach',           'category' => 'Vegetables', 'quantity' => 20,  'unit' => 'kg',  'price_per_unit' => 2.50,  'low_stock_alert' => 5],
            ['name' => 'Potatoes',          'category' => 'Vegetables', 'quantity' => 80,  'unit' => 'kg',  'price_per_unit' => 0.60,  'low_stock_alert' => 15],
            ['name' => 'Carrots',           'category' => 'Vegetables', 'quantity' => 40,  'unit' => 'kg',  'price_per_unit' => 0.90,  'low_stock_alert' => 8],

            // Grains & Flour
            ['name' => 'All-Purpose Flour', 'category' => 'Grains',     'quantity' => 100, 'unit' => 'kg',  'price_per_unit' => 1.00,  'low_stock_alert' => 20],
            ['name' => 'Basmati Rice',      'category' => 'Grains',     'quantity' => 80,  'unit' => 'kg',  'price_per_unit' => 1.80,  'low_stock_alert' => 15],
            ['name' => 'Pasta',             'category' => 'Grains',     'quantity' => 50,  'unit' => 'kg',  'price_per_unit' => 1.50,  'low_stock_alert' => 10],
            ['name' => 'Breadcrumbs',       'category' => 'Grains',     'quantity' => 20,  'unit' => 'kg',  'price_per_unit' => 1.20,  'low_stock_alert' => 5],

            // Spices & Condiments
            ['name' => 'Salt',              'category' => 'Spices',     'quantity' => 500, 'unit' => 'g',   'price_per_unit' => 0.01,  'low_stock_alert' => 100],
            ['name' => 'Black Pepper',      'category' => 'Spices',     'quantity' => 300, 'unit' => 'g',   'price_per_unit' => 0.05,  'low_stock_alert' => 50],
            ['name' => 'Cumin',             'category' => 'Spices',     'quantity' => 200, 'unit' => 'g',   'price_per_unit' => 0.06,  'low_stock_alert' => 50],
            ['name' => 'Paprika',           'category' => 'Spices',     'quantity' => 200, 'unit' => 'g',   'price_per_unit' => 0.06,  'low_stock_alert' => 50],
            ['name' => 'Turmeric',          'category' => 'Spices',     'quantity' => 150, 'unit' => 'g',   'price_per_unit' => 0.08,  'low_stock_alert' => 30],
            ['name' => 'Cinnamon',          'category' => 'Spices',     'quantity' => 100, 'unit' => 'g',   'price_per_unit' => 0.10,  'low_stock_alert' => 20],

            // Oils & Liquids
            ['name' => 'Olive Oil',         'category' => 'Oils',       'quantity' => 20,  'unit' => 'L',   'price_per_unit' => 6.00,  'low_stock_alert' => 4],
            ['name' => 'Sunflower Oil',     'category' => 'Oils',       'quantity' => 30,  'unit' => 'L',   'price_per_unit' => 2.50,  'low_stock_alert' => 5],
            ['name' => 'Soy Sauce',         'category' => 'Oils',       'quantity' => 5000,'unit' => 'ml',  'price_per_unit' => 0.003, 'low_stock_alert' => 500],
            ['name' => 'Tomato Paste',      'category' => 'Oils',       'quantity' => 10,  'unit' => 'kg',  'price_per_unit' => 2.00,  'low_stock_alert' => 3],

            // Sweeteners & Baking
            ['name' => 'Sugar',             'category' => 'Baking',     'quantity' => 60,  'unit' => 'kg',  'price_per_unit' => 0.90,  'low_stock_alert' => 10],
            ['name' => 'Honey',             'category' => 'Baking',     'quantity' => 10,  'unit' => 'kg',  'price_per_unit' => 9.00,  'low_stock_alert' => 2],
            ['name' => 'Baking Powder',     'category' => 'Baking',     'quantity' => 500, 'unit' => 'g',   'price_per_unit' => 0.02,  'low_stock_alert' => 100],
            ['name' => 'Vanilla Extract',   'category' => 'Baking',     'quantity' => 1000,'unit' => 'ml',  'price_per_unit' => 0.05,  'low_stock_alert' => 200],

            // Eggs
            ['name' => 'Eggs',              'category' => 'Dairy',      'quantity' => 300, 'unit' => 'pcs', 'price_per_unit' => 0.25,  'low_stock_alert' => 50],
        ];

        DB::table('ingredients')->insert($ingredients);
    }
}

