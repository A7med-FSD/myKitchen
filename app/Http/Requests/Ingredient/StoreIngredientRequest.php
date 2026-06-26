<?php

namespace App\Http\Requests\Ingredient;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreIngredientRequest extends FormRequest
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
            'name' => 'required|min:3|max:100|unique:ingredients,name',
            'category' => 'required|min:3|max:100',
            'unit' => 'required|in:kg,g,ml,l,pcs',
            'price_per_unit' => 'required|numeric|min:1|max:100000',
            'quantity' => 'required|integer|min:1|max:100000',
            'low_stock_alert' => 'required|integer|min:1|max:100000'
        ];
    }
}
