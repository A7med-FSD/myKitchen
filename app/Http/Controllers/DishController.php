<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    use ApiResponse;

    public function mostOrderdDishes() {
        $dishes = Dish::query()
        ->with('activePromotion')
        ->withCount('orders')
        ->orderBy('orders_count', 'desc')
        ->orderBy('id')
        ->cursorPaginate(3);

        return $this->successResponse(DishResource::collection($dishes), 200, $dishes);
    }

    public function dishes(Request $request) {
        $dishes = Dish::query()
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->when($request->badge !== null && $request->badge !== 'all', fn($q) => $q->where('badge', $request->badge))
            ->with(['category', 'activePromotion'])
            ->withCount('orders')
            ->orderBy('name')
            ->orderBy('id')
            ->cursorPaginate(4);

        return $this->successResponse(DishResource::collection($dishes), 200, $dishes);
    }

    public function mostPopularDishes() {
        $dishes = Dish::query()
        ->with('activePromotion')
        ->withCount('orders')
        ->orderBy('rate', 'desc')
        ->orderBy('id')
        ->cursorPaginate(3);

        return $this->successResponse(DishResource::collection($dishes), 200, $dishes);
    }
}
