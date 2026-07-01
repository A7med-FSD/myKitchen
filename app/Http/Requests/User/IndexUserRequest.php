<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class IndexUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sortBy' => $this->query('sortBy', 'name'), // لو مش مبعوت في الـ URL، ادمج 'name'
            'direction' => $this->query('direction', 'ASC'), // لو مش مبعوت، ادمج 'ASC'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'sometimes|in:vip,regular,new',
            'availability' => 'sometimes|in:active,in_active',
            'sortBy' => 'sometimes|in:name,orders_count,total_spend',
            'direction' => 'sometimes|in:ASC,DESC',
            'searchBy' => 'sometimes|in:name,email,phone',
            'searchBody' => 'required_with:searchBy|min:1|max:100',
        ];

    }
}
