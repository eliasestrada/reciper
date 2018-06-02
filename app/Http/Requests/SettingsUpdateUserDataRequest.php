<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateUserDataRequest extends FormRequest
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
            'name' => 'required|min:3|max:190'
        ];
	}

	// Get the validation messages that apply to the request.
	public function messages() {
		return [
			'name.required' => trans('settings.settings_name_required'),
			'name.min' => trans('settings.settings_name_min'),
			'name.max' => trans('settings.settings_name_max')
		];
	}
}
