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
    // start home apis

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

            $this->calculateTotalPrice($orders);

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
            $dishesData = $validation['dishes'];
            unset($validation['dishes']);

            
            $order = Order::make($validation);
            if($request->promo_code) {
                $promo = Promotion::where('apply_to' , 'all_menu')
                ->orWhere('apply_to', 'special')
                ->where('promo_code', $request->promo_code)->first();
                if($promo) {
                    $order->promotion_value = $promo->value;
                }
            }
            $order->user_id = 1; // temporary user id ('ahmed')
            $order->order_code = $this->generateOrderCode();
            $order->save();

            $dishIds = collect($dishesData)->pluck('id');
            $dishQuantities = collect($dishesData)->pluck('quantity', 'id'); 

            $dishes = Dish::with(['activePromotion' => function ($q) {
                return $q->select('promotions.value');
            }])
            ->whereIn('id', $dishIds)
            ->get();

            $dishesPivotData = [];
            foreach($dishes as $dish) {
                $dishesPivotData[$dish->id] = [
                    'quantity' => $dishQuantities->get($dish->id),
                    'dish_price_at_order' => $dish->price,
                    'dish_name_at_order' => $dish->name,
                    'promotion_value' => $dish->activePromotion->first()?->value
                    ];
            }
            $order->dishes()->attach($dishesPivotData);

            return $this->successResponse(null, 201);
        }
        catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // end home apis 

    // start owner apis 

    public function index(Request $request) {
        $orders = Order::query()
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->when($request->searchBody && $request->searchBody !== '', function ($q) use ($request) {
            if (!$request->searchBy  || $request->searchBy === '' || $request->searchBy === 'all') {
                return $q->where('order_code', 'LIKE', "%$request->searchBody%")
                    ->orWhere('customer_name', 'LIKE', "%$request->searchBody%")
                    ->orWhere('customer_phone', 'LIKE', "%$request->searchBody%");
            } elseif ($request->searchBy === 'order_code') {
                return $q->where('order_code', 'LIKE', "%$request->searchBody%");
            } elseif ($request->searchBy === 'customer_name') {
                return $q->where('customer_name', 'LIKE', "%$request->searchBody%");
            } elseif ($request->searchBy === 'customer_phone'){
                return $q->where('customer_phone', 'LIKE', "%$request->searchBody%");
            }else {
                return $q;
            }
        })
        ->with('dishes')
        ->orderBy('created_at', 'desc')
        ->orderBy('id')
        ->cursorPaginate(4);

        $this->calculateTotalPrice($orders);

        return $this->successResponse(OrderResource::collection($orders), 200, $orders);
    }

    public function updateStatus(Request $request,$orderId) {
        $order = Order::find($orderId);

        if($request->status === 'cancelled' && $order->status !== 'delivered') {
            $order->status = 'cancelled';
            $order->save();
            return $this->successResponse(null, 200);
        }
        
        if($request->status === 'in_progress' && $order->status === 'pending') {
            $order->status = 'in_progress';
            $order->save();
            return $this->successResponse(null, 200);
        }
        
        if($request->status === 'ready' && $order->status === 'in_progress') {
            $order->status = 'ready';
            $order->save();
            return $this->successResponse(null, 200);
        }

        if($request->status === 'delivered' && $order->status === 'ready') {
            $order->status = 'delivered';
            $order->save();
            return $this->successResponse(null, 200);
        }
        return $this->errorResponse('This order cannot be updated', 400);
    }
    // End owner apis 


    //Start Logic functions

    protected function generateOrderCode(): string {
        do {
            $code = now()->format('Ymd') . '-' . rand(1000, 9999);
        } while (Order::where('order_code', $code)->exists());
        return $code;
    }

    protected function calculateTotalPrice($orders) {

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
    //End Logic functions
}
