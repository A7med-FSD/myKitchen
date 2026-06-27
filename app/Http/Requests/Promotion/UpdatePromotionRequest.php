<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
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
        $rules = [
            'title' => 'sometimes|min:3|max:255|unique:promotions,title,' . $this->route('promotion')?->id,
            'apply_to' => 'sometimes|in:all_menu,categories,dishes,special',
            'value' => 'sometimes|numeric|min:1|max:100',
            'start_date' => 'sometimes|date_format:Y-m-d|before:end_date',
            'end_date'   => 'sometimes|date_format:Y-m-d|after:start_date|after:today',
            'is_active' => 'sometimes|boolean',
        ];

        $promotion = $this->route('promotion');
        $oldApplyTo = $promotion->apply_to;
        $newApplyTo = $this->input('apply_to', $oldApplyTo);

        $oldIsGeneral = in_array($oldApplyTo, ['all_menu', 'special']);
        $newIsGeneral = in_array($newApplyTo, ['all_menu', 'special']);
        $oldIsSpecific = in_array($oldApplyTo, ['dishes', 'categories']);
        $newIsSpecific = in_array($newApplyTo, ['dishes', 'categories']);

        if ($oldApplyTo !== $newApplyTo) {
            if ($newIsSpecific) {
                $rules[$newApplyTo] = 'required|array|min:1';
                $rules[$newApplyTo . '.*']  = 'required|integer|exists:' . $newApplyTo . ',id';
            } elseif (($oldIsSpecific && $newIsGeneral)) {
                $rules['promo_code'] = 'required|min:3|max:255|string';
            } elseif ($oldIsGeneral && $newIsGeneral) {
                $rules['promo_code'] = 'sometimes|min:3|max:255|string';
            }
        } else {
            if ($newIsSpecific) {
                $rules[$newApplyTo] = 'sometimes|array|min:1';
                $rules[$newApplyTo . '.*']  = 'sometimes|integer|exists:' . $newApplyTo . ',id';
            } else {
                $rules['promo_code'] = 'sometimes|min:3|max:255|string';
            }
        }

        return $rules;
    }
}
