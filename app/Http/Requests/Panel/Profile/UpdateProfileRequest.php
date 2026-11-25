<?php

namespace App\Http\Requests\Panel\Profile;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
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
        if ($this->input('_form') == 'update-password') {
            return [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'string', 'confirmed', Password::defaults()],
            ];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id() . ',id'],
            'role' => ['nullable', 'integer', 'exists:roles,id'],
        ];
    }
}
