<?php

namespace App\Http\Controllers;
use App\ApiResponse;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    use ApiResponse;
    // home apis

    public function orders(Request $request , $userId) {
        try {
            $orders = Order::where('user_id', $userId)
            ->when($request->order_code, function ($query) use ($request) {
                $query->where('order_code', 'like', '%' . $request->order_code . '%');
            })
            ->when($request->time && $request->time !== "all", function ($query) use ($request) {
                if ($request->time === "week") {
                    $query->where('created_at', '>=', now()->subWeek());
                } elseif ($request->time === "month") {
                    $query->where('created_at', '>=', now()->subMonth());
                } elseif ($request->time === "year") {
                    $query->where('created_at', '>=', now()->subYear());
                }
            })
            ->with('dishes')
            ->orderBy('created_at', 'desc')
            ->get();

            //start calculate Total Price
            foreach ($orders as $order) {
                $order->total_price = 0;
                foreach ($order->dishes as $dish) {
                    $dish->total_price = 0;
                    if($dish->pivot->promotion_value !== null) {
                        $dish->total_price += (((100 - $dish->pivot->promotion_value) / 100) * $dish->pivot->dish_price_at_order) * $dish->pivot->quantity; 
                    }else {
                        $dish->total_price += $dish->pivot->dish_price_at_order * $dish->pivot->quantity;
                    }
                    $order->total_price += $dish->total_price;
                }
                if($order->promotion_value !== null) {
                    $order->total_price_before_promotion = round($order->total_price, 2);
                    $order->total_price = ((100 - $order->promotion_value) / 100) * $order->total_price;
                }
            }

            //end calculate Total Price
            return $this->successResponse(OrderResource::collection($orders), 200);
        }
        catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function placeOrder(OrderRequest $request) {
        try {
            $validation = $request->validated();
            $dishes = $validation['dishes'];
            unset($validation['dishes']);
            $dishesData = [];

            
            $order = Order::make($validation);
            if($request->promo_code) {
                $promo = Promotion::where('apply_to' , 'all_menu')
                ->where('promo_code', $request->promo_code)->first();
                if($promo) {
                    $order->promotion_value = $promo->value;
                }
            }
            $order->user_id = 1; // temporary user id ('ahmed')
            $order->order_code = $this->generateOrderCode();
            $order->save();
            
            foreach($dishes as $dish) {
                $dishData = Dish::with('activePromotion')->find($dish['id']);
                $promotion_value = $dishData->activePromotion->first()?->value;
                $dishesData[$dish['id']] = [
                    'quantity' => $dish['quantity'],
                    'dish_price_at_order' => $dishData->price,
                    'dish_name_at_order' => $dishData->name,
                    'promotion_value' => $promotion_value
                    ];
                    }
            $order->dishes()->attach($dishesData);

            return $this->successResponse(null, 200);
        }
        catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    protected function generateOrderCode(): string
    {
        do {
            $code = now()->format('Ymd') . '-' . rand(1000, 9999);
        } while (Order::where('order_code', $code)->exists());
        return $code;
    }
}
