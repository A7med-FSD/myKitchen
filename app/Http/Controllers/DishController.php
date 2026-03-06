<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\DishRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DishController extends Controller
{
    use ApiResponse;

    // home apis 
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

    // owner apis
    public function store(DishRequest $request) {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $imgExt = $request->image->getClientOriginalExtension();
                $imgName = time() . '.' . $imgExt;
                $request->file('image')->storeAs('dishes', $imgName, 'public');
                $data['image'] = $imgName;
            }

            $dish = Dish::create($data);
            
            return $this->successResponse(new DishResource($dish), 201);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(DishRequest $request, $id) {
        try {
            $dish = Dish::findOrFail($id);
            $data = $request->validated();

            if($request->hasFile('image')) {
                //delete old image
                if($dish->image) {
                    $oldPath = 'dishes/' . $dish->image;
                    if(Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $imgExt = $request->image->getClientOriginalExtension();
                $imgName = time() . '.' . $imgExt;
                $request->file('image')->storeAs('dishes', $imgName, 'public');
                $data['image'] = $imgName;
            }

        $dish->update($data);
        return $this->successResponse(new DishResource($dish), 200);
        }
        catch(ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    } 

    public function delete($id) {
        try {
            $dish = Dish::findOrFail($id);

            //delete old image
            if($dish->image) {
                $oldPath = 'dishes/' . $dish->image;
                if(Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $dish->delete();
            return $this->successResponse(null, 204);
        }
        catch(ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
