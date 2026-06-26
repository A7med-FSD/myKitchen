<?php

namespace App\Http\Requests\Ingredient;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIngredientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|min:3|max:100|unique:ingredients,name',
            'category' => 'sometimes|min:3|max:100',
            'unit' => 'sometimes|in:kg,g,ml,l,pcs',
            'price_per_unit' => 'sometimes|min:1|max:100000',
            'quantity' => 'sometimes|min:1|max:100000',
            'low_stock_alert' => 'sometimes|min:1|max:100000'
        ];
    }
}
