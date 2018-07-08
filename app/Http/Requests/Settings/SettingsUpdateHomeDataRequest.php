<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateHomeDataRequest extends FormRequest
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
            'title' => 'max:190',
			'text' => 'max:900'
        ];
	}

	// Get the validation messages that apply to the request.
    public function messages()
    {
        return [
            'title.max' => trans('settings.settings_title_max'),
			'text.max' => trans('settings.settings_text_max')
        ];
    }
}
