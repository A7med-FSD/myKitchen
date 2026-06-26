<?php

namespace App\Http\Requests\Dish;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetDishRequest extends FormRequest
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
            'badge' => ['sometimes', 'in:all,special,featured,new,recommended'],
            'searchBody' => ['sometimes', 'min:1', 'max:100'],
            'searchBy' => ['required_with:searchBody', 'in:all,name,description'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'is_available' => ['sometimes', 'boolean', Rule::when(!auth()->guard('owner')->check(), ['prohibited']),]
        ];
    }
}
