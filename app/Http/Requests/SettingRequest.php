<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            "Customer_settings" => 'sometimes|array|min:1',

            "Customer_settings.VIP_settings" => 'sometimes|array|min:1',
            "Customer_settings.VIP_settings.MIN_SPEND" => "sometimes|numeric|min:1|max:100000",
            "Customer_settings.VIP_settings.MIN_ORDER_COUNT" => "sometimes|integer|min:1|max:100000",

            "Customer_settings.Regular_settings" => 'sometimes|array|min:1',
            "Customer_settings.Regular_settings.MIN_SPEND" => "sometimes|numeric|min:1|max:100000",
            "Customer_settings.Regular_settings.MIN_ORDER_COUNT" => "sometimes|integer|min:1|max:100000",
        ];
    }
}
