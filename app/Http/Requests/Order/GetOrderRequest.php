<?php

namespace App\Http\Requests\Order;

use App\Rules\OrderCodeRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetOrderRequest extends FormRequest
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
            'order_code' => ['sometimes', 'string', 'min:1', 'max:20'],
            'time' => ['sometimes', 'string', 'in:week,month,year,all'],
        ];
    }
}
