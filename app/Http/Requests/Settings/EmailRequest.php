<?php

namespace App\Http\Requests\Settings;

use App\Rules\UniqueEmailRule;
use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.
    public function rules()
    {
        $max_length = config('valid.settings.email.max');

        return ['email' => [
            'nullable',
            new UniqueEmailRule,
            "max:{$max_length}",
            'email',
        ]];
    }

    // Get the validation messages that apply to the request.
    public function messages()
    {
        return [
            'email.max' => trans('settings.email_max'),
            'email.email' => trans('settings.email_email'),
        ];
    }
}
