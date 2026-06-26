<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Http\Requests\GetDishRequest;
use App\Http\Requests\DishRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Repositories\DishRepository;
use App\Traits\ManagesFiles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DishController extends Controller
{
    use ApiResponse, ManagesFiles;
    
    public function __construct(private DishRepository $repo)
    {
        
    }

    // Start home apis 
    public function mostOrderedDishes() {
        $dishes = $this->repo->getMostOrderedDishes();

        return $this->successResponse(DishResource::collection($dishes), 200, $dishes);
    }

    public function mostPopularDishes() {
        $dishes = $this->repo->getMostPopularDishes();

        return $this->successResponse(DishResource::collection($dishes), 200);
    }

    // End home apis 

    public function index(GetDishRequest $request) {
        $data = $request->validated();
        $dishes = $this->repo->getDishes($data);
        
        return $this->successResponse(DishResource::collection($dishes), 200, $dishes);
    }
    
    // owner apis

    public function store(DishRequest $request) {
        try {
            $data = $request->validated();

            $data['image'] = $this->uploadFile($request->file('image'), 'dishes');

            $dish = Dish::create($data);
            
            return $this->successResponse(new DishResource($dish), 201);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(DishRequest $request, int $id) {
        try {
            $dish = Dish::findOrFail($id);
            $data = $request->validated();

            if($request->hasFile('image')) {
                $data['image'] = $this->updateFile($request->file('image'), 'dishes', $dish->image);
            }

            $dish->update($data);
            return $this->successResponse(new DishResource($dish), 200);
        }
        catch(ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    } 

    public function destroy(int $id) {
        try {
            $dish = Dish::findOrFail($id);

            //delete old image
            if($dish->image) {
                $this->deleteFile($dish->image, 'dishes');
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
