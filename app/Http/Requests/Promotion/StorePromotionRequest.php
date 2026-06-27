<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
            'title' => 'required|min:3|max:255|unique:promotions,title',
            'apply_to' => 'required|in:all_menu,categories,dishes,special',
            'promo_code' => 'nullable|required_if:apply_to,all_menu,special|min:3|max:255|string',
            'value' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date_format:Y-m-d|before:end_date',
            'end_date'   => 'required|date_format:Y-m-d|after:start_date|after:today',
            'is_active' => 'nullable|boolean',
            'dishes' => 'nullable|required_if:apply_to,dishes|array|min:1',
            'dishes.*' => 'nullable|required_if:apply_to,dishes|integer|exists:dishes,id',
            'categories' => 'nullable|required_if:apply_to,categories|array|min:1',
            'categories.*' => 'nullable|required_if:apply_to,categories|integer|exists:categories,id'
        ];
    }
}
