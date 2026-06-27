<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'status' => 'sometimes|in:all,active,expired,scheduled',
            'searchBy' => 'sometimes|in:all,title,promo_code',
            'searchBody' => 'sometimes|min:1|max:100'
        ];
    }
}
