<?php

namespace App\Http\Requests\Dish;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
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
            'image' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
            'name' => 'required|string|unique:dishes,name|min:3|max:255',
            'description' => 'required|string|max:500|min:5',
            'price' => 'required|numeric|min:10|max:1000000',
            'category_id' => 'required|exists:categories,id',
            'time_preparing' => 'required|integer|min:5|max:1000',
            'badge' => 'nullable|string|in:special,featured,new,recommended',
            'is_available' => 'required|boolean',
        ];
    }
}
