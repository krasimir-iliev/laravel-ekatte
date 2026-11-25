<?php

namespace App\Http\Requests\Panel\Region;

use Astrotomic\Translatable\Locales;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:4', 'unique:regions'],
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
