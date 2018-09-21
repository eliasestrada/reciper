<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingsGeneralRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.
    public function rules()
    {
        $min_name = config('validation.settings_name_min');
        $max_name = config('validation.settings_name_max');
        $max_about_me = config('validation.settings_about_me');

        return [
            'name' => "required|min:$min_name|max:$max_name",
            'about_me' => "max:$max_about_me",
        ];
    }

    // Get the validation messages that apply to the request.
    public function messages()
    {
        return [
            'name.required' => trans('settings.settings_name_required'),
            'name.min' => trans('settings.settings_name_min'),
            'name.max' => trans('settings.settings_name_max'),
        ];
    }
}
