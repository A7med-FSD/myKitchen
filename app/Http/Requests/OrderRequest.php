<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'customer_name' => 'required|min:3|max:255',
            'customer_phone' => 'required|regex:/^(010|011|012|015)[0-9]{8}$/',
            'address_text' => 'required|min:10|max:255',
            'delivery_notes' => 'nullable|max:1000',
            'address_link' => 'nullable|url',
            'payment_method' => 'required|in:visa,vodafone,instaPay,fawry',
            'promo_code' => 'nullable|exists:promotions,promo_code',
            'dishes' => 'required|min:1',
            'dishes.*.id' => 'required|exists:dishes,id',
            'dishes.*.name' => 'required',
            'dishes.*.quantity' => 'required|min:1',
            
        ];
    }
}
