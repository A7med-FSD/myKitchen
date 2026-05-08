<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use App\Events\OrderDelivered;

class OrderService {

    public function calculateTotalPrice($orders) {
        foreach ($orders as $order) {
            $order->total_price = 0;

            foreach ($order->dishes as $dish) {
                $dish->total_price = 0;
                if ($dish->pivot->promotion_value !== null) {
                $dish->total_price += (((100 - $dish->pivot->promotion_value) / 100) * $dish->pivot->dish_price_at_order) * $dish->pivot->quantity;
                } else {
                $dish->total_price += $dish->pivot->dish_price_at_order * $dish->pivot->quantity;
                }
                $order->total_price += $dish->total_price;
            }

            if ($order->promotion_value !== null) {
                $order->total_price_before_promotion = round($order->total_price, 2);
                $order->total_price = ((100 - $order->promotion_value) / 100) * $order->total_price;
            }
        }
    }

    public function generateOrderCode(): string {
        $orderNum = Redis::incr('order_num');
        $code = now()->format('Ymd') . '-' . $orderNum;

        if ($orderNum == 1) {
        $midNight = now()->endOfDay();
        Redis::expireAt('order_num', $midNight->timestamp);
        }

        return $code;
    }


    public function attachDishes($order, $dishes, $dishQuantities) {
        $dishesPivotData = [];
        foreach ($dishes as $dish) {
        $promotion_value = max($dish->activePromotion->first()?->value, $dish->category->activePromotion->first()?->value);
        $dishesPivotData[$dish->id] = [
            'quantity' => $dishQuantities->get($dish->id),
            'dish_price_at_order' => $dish->price,
            'dish_name_at_order' => $dish->name,
            'promotion_value' => $promotion_value
        ];
        }
        $order->dishes()->attach($dishesPivotData);
    }

    public function updateStatus($order, $newStatus): bool {
        $updated = false;
        if ($newStatus === 'cancelled' && $order->status !== 'delivered') {
            $order->status = 'cancelled';
            $updated = true;
        }

        elseif ($newStatus === 'in_progress' && $order->status === 'pending') {
            $order->status = 'in_progress';
            $updated = true;
        }

        elseif ($newStatus === 'ready' && $order->status === 'in_progress') {
            $order->status = 'ready';
            $updated = true;
        }

        elseif ($newStatus === 'delivered' && $order->status === 'ready') {
            $order->status = 'delivered';
            OrderDelivered::dispatch($order->user_id);
            $updated = true;
        }

        if($updated) {
            $order->save();
        }
        return $updated;
    }
}