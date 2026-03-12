<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    use ApiResponse;

    // index function for home & owner panles
    public function index() {
        $categories = Category::get();
        
        return $this->successResponse(CategoryResource::collection($categories), 200);
    }

    // Start owner apis
    
    public function store(CategoryRequest $request) {
        Category::create($request->validated());

        return $this->successResponse(null, 201);
    }

    public function delete($categoryId) {
        try {
            $category = Category::withCount('dishes')->findOrFail($categoryId);
            if($category->dishes_count > 0) {
                return $this->errorResponse('can\'t delete category that has dishes..!', 422);
            }

            $category->delete();

            return $this->successResponse(null, 204);
        }catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }   

    // End owner apis
}
