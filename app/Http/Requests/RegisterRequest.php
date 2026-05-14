<?php

namespace App\Http\Requests;


use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'phone' => ['required', new PhoneRule(), 'unique:users,phone'],
            'password' => 'required|min:6|max:20|confirmed', // input confirme filed must named "password_confirmation"
            'email' => 'nullable|email|unique:users,email',
            'address_link' => ['nullable'],
            'latitude'  => 'nullable|required_if:longitude,between:-99,99',
            'longitude'  => 'nullable|required_if:latitude,between:-180,180',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }
}