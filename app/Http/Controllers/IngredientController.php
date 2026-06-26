<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ingredient\StoreIngredientRequest;
use App\Http\Requests\Ingredient\UpdateIngredientRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
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

    public function store(StoreIngredientRequest $request) {
        $data = $request->validated();
        $ingredient = Ingredient::create($data);

        return $this->successResponse( new IngredientResource($ingredient), 201);

    }

    public function update(UpdateIngredientRequest $request, $ingredientId) {
        $data = $request->validated();
        $ingredient = Ingredient::findOrFail($ingredientId);

        $ingredient->update($data);
        return $this->successResponse( new IngredientResource($ingredient), 200);
        
    }

    public function delete($ingredientId) {
        $ingredient = Ingredient::findOrFail($ingredientId);
        $ingredient->delete();
        return $this->successResponse(null, 204);
    }
}
