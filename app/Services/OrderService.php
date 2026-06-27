<?php

namespace App\Services;

use App\Helpers\OrderCode;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

class OrderService {

    public function __construct(protected OrderRepository $repo)
    {
    }

    /**
     * @return CursorPaginator<Order>
     */
    public function processIndex(array $data): CursorPaginator {
        $orders = $this->repo->getAllOrders($data);

        $this->calculateTotalPrice($orders);

        return $orders;
    }


    /**
    * @return Collection<int, Order>
    */
    public function processOrders(array $data, $userId): Collection {
        $orders = $this->repo->getOrders($data, $userId);

        $this->calculateTotalPrice($orders);

        return $orders;
    }

    public function handlePlaceOrder(array $validation, $userId): string {
        $dishesData = $validation['dishes'];
        unset($validation['dishes']);

        $order = Order::make($validation);
        if ($validation['promo_code'] ?? false) {
            $order->promotion_value = $this->repo->getOrderActivePromo($validation['promo_code']);
        }

        $order->user_id = $userId;
        $order->order_code = OrderCode::generateOrderCode();
        $order->save();

        $dishIds = collect($dishesData)->pluck('id');
        $dishQuantities = collect($dishesData)->pluck('quantity', 'id');

        $dishes = $this->repo->getOrderDishesPromo($dishIds);
        $this->attachDishes($order, $dishes, $dishQuantities);

        return $order->order_code;
    }

    private function calculateTotalPrice(iterable $orders): void {

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
                $order->total_price = round(((100 - $order->promotion_value) / 100) * $order->total_price, 2);
            }
        }
    }

    private function attachDishes($order, $dishes, $dishQuantities) {
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
}