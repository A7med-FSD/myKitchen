<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            // أوردر 1 — Grilled Chicken + Lentil Soup
            [
                'customer_name'  => 'Ahmed Ali',
                'customer_phone' => '01001234567',
                'status'         => 'delivered',
                'order_code'     => 1001,
                'total_price'    => 120,
                'payment_method' => 'cash',
                'dishes'         => ['Grilled Chicken with Rice', 'Lentil Soup'],
            ],
            // أوردر 2 — Grilled Chicken + Chocolate Lava Cake
            [
                'customer_name'  => 'Sara Mohamed',
                'customer_phone' => '01009876543',
                'status'         => 'delivered',
                'order_code'     => 1002,
                'total_price'    => 135,
                'payment_method' => 'cash',
                'dishes'         => ['Grilled Chicken with Rice', 'Chocolate Lava Cake'],
            ],
            // أوردر 3 — Mixed Grill Platter
            [
                'customer_name'  => 'Mohamed Hassan',
                'customer_phone' => '01112233445',
                'status'         => 'delivered',
                'order_code'     => 1003,
                'total_price'    => 145,
                'payment_method' => 'card',
                'dishes'         => ['Mixed Grill Platter'],
            ],
            // أوردر 4 — Chocolate Lava Cake + Mango Smoothie
            [
                'customer_name'  => 'Nour Khaled',
                'customer_phone' => '01234567890',
                'status'         => 'delivered',
                'order_code'     => 1004,
                'total_price'    => 85,
                'payment_method' => 'cash',
                'dishes'         => ['Chocolate Lava Cake', 'Mango Smoothie'],
            ],
            // أوردر 5 — Grilled Chicken + Mixed Grill
            [
                'customer_name'  => 'Youssef Ibrahim',
                'customer_phone' => '01156789012',
                'status'         => 'in_progress',
                'order_code'     => 1005,
                'total_price'    => 230,
                'payment_method' => 'cash',
                'dishes'         => ['Grilled Chicken with Rice', 'Mixed Grill Platter'],
            ],
            // أوردر 6 — Chocolate Lava Cake
            [
                'customer_name'  => 'Layla Samir',
                'customer_phone' => '01067891234',
                'status'         => 'delivered',
                'order_code'     => 1006,
                'total_price'    => 50,
                'payment_method' => 'card',
                'dishes'         => ['Chocolate Lava Cake'],
            ],
        ];

        foreach ($orders as $orderData) {
            $dishNames = $orderData['dishes'];
            unset($orderData['dishes']);

            $order = Order::create($orderData);

            foreach ($dishNames as $dishName) {
                $dish = Dish::where('name', $dishName)->first();

                if ($dish) {
                    $order->dishes()->attach($dish->id, [
                        'quantity'             => 1,
                        'dish_price_at_order'  => $dish->price,
                        'dish_name_at_order'   => $dish->name,
                        'promotion_value'      => null,
                    ]);
                }
            }
        }
    }
}
