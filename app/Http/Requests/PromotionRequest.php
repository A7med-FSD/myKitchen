<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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

        if ($this->isMethod('patch')) {
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


        return [
            'title' => 'required|min:3|max:255|unique:promotions,title',
            'apply_to' => 'required|in:all_menu,categories,dishes,special',
            'promo_code' => 'nullable|required_if:apply_to,all_menu,special|min:3|max:255|string',
            'value' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date_format:Y-m-d|before:end_date',
            'end_date'   => 'required|date_format:Y-m-d|after:start_date|after:today',
            'is_active' => 'nullable|boolean',
            'dishes' => 'nullable|required_if:apply_to,dishes|array|min:1',
            'dishes.*' => 'nullable|required_if:apply_to,dishes|integer|exists:dishes,id',
            'categories' => 'nullable|required_if:apply_to,categories|array|min:1',
            'categories.*' => 'nullable|required_if:apply_to,categories|integer|exists:categories,id'
        ];
    }
}
