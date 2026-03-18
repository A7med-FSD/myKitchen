<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
        return [
            'title' => 'required|min:3|max:255|unique:promotions,title',
            'apply_to' => 'required|in:all_menu,categories,dishes,special',
            'promo_code' => 'nullable|required_if:apply_to,all_menu,special|string',
            'value' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date_format:Y-m-d|before:end_date',
            'end_date'   => 'required|date_format:Y-m-d|after:start_date|after:today',
            'is_active' => 'nullable|boolean',
            'dishes' => 'nullable|required_if:apply_to,dishes|array|min:1',
            'dishes.*' => 'integer|exists:dishes,id',
            'categories' => 'nullable|required_if:apply_to,categories}|array|min:1',
            'categories.*' => 'integer|exists:categories,id'
        ];
    }
}
