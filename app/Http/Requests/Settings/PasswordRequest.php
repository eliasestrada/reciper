<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.
    public function rules()
    {
        return [
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    // Get the validation messages that apply to the request.
    public function messages()
    {
        return [
            'old_password.required' => trans('settings.pwd_required'),
            'password.required' => trans('settings.new_pwd_required'),
            'password.min' => trans('settings.pwd_min'),
            'password.confirmed' => trans('settings.pwd_confirmed'),
        ];
    }
}
