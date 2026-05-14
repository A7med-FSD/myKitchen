<?php

namespace App\Http\Controllers;
use App\ApiResponse;
use App\Http\Requests\Order\GetOrderRequest;
use App\Http\Requests\Order\IndexOrderRequest;
use App\Http\Requests\Order\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
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

    public function orders(GetOrderRequest $request) {
        $data = $request->validated();
        $orders = $this->service->processOrders($data, Auth::id());
        
        return $this->successResponse(OrderResource::collection($orders), 200);
    }

    public function placeOrder(PlaceOrderRequest $request) {

        $validation = $request->validated();

        $order_code = $this->service->handlePlaceOrder($validation, $request->user()->id);

        return $this->successResponse($order_code, 201);
    }

    // end home apis 

    // start owner apis 

    public function index(IndexOrderRequest $request) {
        $data = $request->validated();
        
        $orders = $this->service->processIndex($data);

        return $this->successResponse(OrderResource::collection($orders), 200, $orders);
    }

    public function updateStatus(Request $request,$orderId) {
        $order = Order::find($orderId);

        $order->evaluateStatus($request->status);

        return $this->successResponse(null, 200);
    }
    // End owner apis 
}
