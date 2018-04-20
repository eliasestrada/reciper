<?php

namespace App\Http\Requests;

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
			'text'  => 'max:900'
        ];
	}

	// Get the validation messages that apply to the request.
    public function messages()
    {
        return [
            'title.max' => 'Заголовок должен быть не более 190 символов',
			'text.max'  => 'Текст должен быть не более 900 символов'
        ];
    }
}
