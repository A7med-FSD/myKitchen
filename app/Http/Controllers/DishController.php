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

    // Start home apis 
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
            ->where('is_available', true)
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->when($request->badge !== null && $request->badge !== 'all', fn($q) => $q->where('badge', $request->badge))
            ->when($request->searchBody && $request->searchBody !== '', function ($q) use ($request) {
                if (!$request->searchBy  || $request->searchBy === '' || $request->searchBy === 'all') {
                    return $q->where('name', 'LIKE', "%$request->searchBody%")
                        ->orWhere('description', 'LIKE', "%$request->searchBody%");
                } elseif ($request->searchBy === 'name') {
                    return $q->where('name', 'LIKE', "%$request->searchBody%");
                } elseif ($request->searchBy === 'description') {
                    return $q->where('description', 'LIKE', "%$request->searchBody%");
                } else {
                    return $q;
                }
            })
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

    // End home apis 

    // owner apis
    public function index(Request $request) {
        $dishes = Dish::query()
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->when($request->badge !== null && $request->badge !== 'all', fn($q) => $q->where('badge', $request->badge))
            ->when($request->searchBody && $request->searchBody !== '' , function($q) use($request) {
                if(!$request->searchBy  || $request->searchBy === '' || $request->searchBy === 'all') {
                    return $q->where('name', 'LIKE', "%$request->searchBody%")
                    ->orWhere('description', 'LIKE', "%$request->searchBody%");
                }elseif($request->searchBy === 'name') {
                    return $q->where('name', 'LIKE', "%$request->searchBody%");
                }elseif($request->searchBy === 'description') {
                    return $q->where('description', 'LIKE', "%$request->searchBody%");
                } else {
                    return $q;
                }
            })
            ->with(['category', 'activePromotion'])
            ->withCount('orders')
            ->orderBy('name')
            ->orderBy('id')
            ->cursorPaginate(4);

        return $this->successResponse(DishResource::collection($dishes), 200, $dishes);
    }

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
