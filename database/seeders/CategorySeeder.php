<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Main Dishes',  'emoji' => '🍽️'],
            ['name' => 'Grills',       'emoji' => '🔥'],
            ['name' => 'Sandwiches',   'emoji' => '🥪'],
            ['name' => 'Pastries',     'emoji' => '🥐'],
            ['name' => 'Salads',       'emoji' => '🥗'],
            ['name' => 'Soups',        'emoji' => '🍲'],
            ['name' => 'Desserts',     'emoji' => '🍰'],
            ['name' => 'Drinks',       'emoji' => '🥤'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
