<?php

namespace App\Http\Requests\Shared\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required', 'string'],
            'password' => [
                'bail',
                'required',
                'confirmed',
                'max:20',
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }
}
