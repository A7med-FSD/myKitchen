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
use Illuminate\Support\Facades\Auth;
use App\Services\OrderService;

class OrderController extends Controller
{
    use ApiResponse;
    // start home apis

    public function __construct(private OrderService $service)
    {
    }

    public function orders(Request $request) {
        $orders = Order::where('user_id', Auth::id())
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

        $this->service->calculateTotalPrice($orders);
        
        return $this->successResponse(OrderResource::collection($orders), 200);
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
            $order->user_id = $request->user()->id; 
            $order->order_code = $this->service->generateOrderCode();
            $order->save();

            $dishIds = collect($dishesData)->pluck('id');
            $dishQuantities = collect($dishesData)->pluck('quantity', 'id'); 

            $dishes = Dish::with(['activePromotion' => function ($q) { return $q->select('promotions.value'); },
                'category.activePromotion' => function ($q) { return $q->select('promotions.value'); }])
            ->whereIn('id', $dishIds)
            ->get();

            $this->service->attachDishes($order, $dishes, $dishQuantities);

            return $this->successResponse($order->order_code, 201);
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

        $this->service->calculateTotalPrice($orders);

        return $this->successResponse(OrderResource::collection($orders), 200, $orders);
    }

    public function updateStatus(Request $request,$orderId) {
        $order = Order::find($orderId);

        $updated = $this->service->updateStatus($order, $request->status);
        if($updated) {
            return $this->successResponse(null, 200);
        }
        return $this->errorResponse('This order cannot be updated', 400);
    }
    // End owner apis 
}
