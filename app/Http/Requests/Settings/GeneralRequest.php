<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class GeneralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $name_min = config('valid.settings.general.name.min');
        $name_max = config('valid.settings.general.name.max');
        $about_me_max = config('valid.settings.general.status.max');

        return [
            'name' => "nullable|min:$name_min|max:$name_max",
            'status' => "max:$about_me_max",
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.min' => trans('settings.name_min'),
            'name.max' => trans('settings.name_max'),
            'status.max' => trans('settings.about_me_max'),
        ];
    }
}
