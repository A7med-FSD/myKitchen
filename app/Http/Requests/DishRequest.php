<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('patch')) {
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

    public function messages() {
        return [
            'name.required' => "this field is required...!",
        ];
    }
}
