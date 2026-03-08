<?php

namespace App\Http\Controllers;
use App\ApiResponse;
use App\Http\Resources\OrderResource;
use App\Models\Order;
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
}
