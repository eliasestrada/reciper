<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateUserPasswordRequest extends FormRequest
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
			'password'     => 'required|string|min:6|confirmed'
        ];
	}
	
	// Get the validation messages that apply to the request.
	public function messages() {
		return [
			'old_password.required' => trans('my_valid.settings_pwd_required'),
            'password.required'     => trans('my_valid.settings_new_pwd_required'),
            'password.min'          => trans('my_valid.settings_pwd_min'),
            'password.confirmed'    => trans('my_valid.settings_pwd_confirmed')
		];
	}
}
