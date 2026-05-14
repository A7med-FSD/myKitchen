<?php

namespace App\Http\Requests\Order;

use App\Rules\OrderCodeRule;
use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
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
            'status' => ['sometimes', 'in:pending,in_progress,ready,delivered,cancelled'],
            'searchBody' => ['sometimes', 'min:1', 'max:100'],
            'searchBy' => ['sometimes', 'in:all,order_code,customer_name,customer_phone']
        ];
    }
}
