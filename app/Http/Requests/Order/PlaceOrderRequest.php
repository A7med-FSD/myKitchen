<?php

namespace App\Http\Requests\Order;

use App\Rules\DishRule;
use App\Rules\OrderCodeRule;
use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
            'customer_name' => 'required|min:3|max:255',
            'customer_phone' => ['required', new PhoneRule()],
            'address_text' => 'required|min:3|max:255',
            'address_link' => 'nullable|url',
            'delivery_notes' => 'nullable|max:1000',
            'payment_method' => 'required|in:visa,vodafone,instaPay,fawry',
            'promo_code' => ['sometimes', 'exists:promotions,promo_code'],
            'dishes' => 'required|min:1',
            'dishes.*.id' => ['required', 'exists:dishes,id', new DishRule()],
            'dishes.*.quantity' => 'required|integer|min:1',
        ];
    }
}
