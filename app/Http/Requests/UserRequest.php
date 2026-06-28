<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
     * Route is always PATCH — creation happens in RegisterRequest.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = Auth::id();

        $rules = [
            'name'         => ['sometimes', 'string','min:3', 'max:255'],
            'phone'        => ['sometimes', 'string', new PhoneRule(), 'unique:users,phone,' . $userId],
            'email'        => ['sometimes', 'nullable', 'email', 'unique:users,email,' . $userId],
            'image'        => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'address_text' => ['sometimes', 'nullable', 'string', 'max:500'],
        ];

        if($this->has('latitude') || $this->has('longitude')) {
            $rules['latitude']  = ['required', 'numeric', 'between:-90,90',   'required_with:longitude'];
            $rules['longitude'] = ['required', 'numeric', 'between:-180,180', 'required_with:latitude'];
        }

        return $rules;
    }
}

