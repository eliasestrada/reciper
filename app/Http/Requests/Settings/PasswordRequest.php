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
        $pwd_min = config('valid.settings.password.min');
        $pwd_max = config('valid.settings.password.max');

        return [
            'old_password' => 'required|string',
            'password' => "required|string|min:$pwd_min|max:$pwd_max|confirmed",
        ];
    }

    // Get the validation messages that apply to the request.
    public function messages()
    {
        return [
            'old_password.required' => trans('settings.old_pwd_required'),
            'old_password.string' => trans('settings.old_pwd_string'),
            'password.required' => trans('settings.pwd_required'),
            'password.string' => trans('settings.pwd_string'),
            'password.min' => trans('settings.pwd_min'),
            'password.max' => trans('settings.pwd_max'),
            'password.confirmed' => trans('settings.pwd_confirmed'),
        ];
    }
}
