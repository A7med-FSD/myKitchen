<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiResponse;
use App\Http\Requests\IngredientRequest;
use App\Models\Ingredient;
use App\Http\Resources\IngredientResource;

class IngredientController extends Controller
{
    use ApiResponse;

    public function index() {
        $ingredients = Ingredient::get();

        return $this->successResponse(IngredientResource::collection($ingredients), 200);
    }

    public function store(IngredientRequest $request) {
        try {
            $data = $request->validated();
            $ingredient = Ingredient::create($data);

            return $this->successResponse(IngredientResource::collection($ingredient), 201);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(IngredientRequest $request, $ingredientId) {
        try {       
            $data = $request->validated();
            $ingredient = Ingredient::findOrFail($ingredientId);

            $ingredient->update($data);
            return $this->successResponse(IngredientResource::collection($ingredient), 200);
        }catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function delete($ingredientId) {
        try {
            $ingredient = Ingredient::findOrFail($ingredientId);
            $ingredient->delete();
            return $this->successResponse(null, 204);
        }catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
