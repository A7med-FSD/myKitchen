<?php

namespace App\Http\Requests\Dish;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDishRequest extends FormRequest
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
            'image' => 'sometimes|image|mimes:png,jpg,jpeg,gif|max:2048',
            'name' => 'sometimes|string|unique:dishes,name,' . $this->route('id') . '|min:3|max:255',
            'description' => 'sometimes|string|max:500|min:5',
            'price' => 'sometimes|numeric|min:10|max:1000000',
            'category_id' => 'sometimes|exists:categories,id',
            'time_preparing' => 'sometimes|integer|min:5|max:1000',
            'badge' => 'sometimes|string|in:special,featured,new,recommended',
            'is_available' => 'sometimes|boolean',
        ];
    }
}
