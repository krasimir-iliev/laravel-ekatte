<?php

namespace App\Http\Requests\Panel\Settlement;

use Astrotomic\Translatable\Locales;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettlementRequest extends FormRequest
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
            'settlement_kind_id' => ['required', 'integer', 'exists:settlement_kinds,id'],
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'municipality_id' => ['required', 'integer', 'exists:municipalities,id,district_id,' . $this->district_id],
            'town_hall_id' => ['required', 'integer', 'exists:town_halls,id,municipality_id,' . $this->municipality_id],
            'ekatte' => ['required', 'string', 'max:5', 'unique:settlements,ekatte,' . $this->route('settlement') . ',id'],
        ];

        $locales = app(Locales::class)->all();

        foreach ($locales as $locale) {
            $rules[$locale . '.name'] = ['required', 'string', 'max:64'];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        $attributes = [];

        $locales = app(Locales::class)->all();

        foreach ($locales as $locale) {
            $attributes[$locale . '.name'] = __('validation.attributes.name');
        }

        return $attributes;
    }
}
