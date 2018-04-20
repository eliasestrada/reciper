<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'имя' => 'required|min:3|max:50',
			'почта' => 'required|email',
			'сообщение' => 'required|min:20|max:5000'
        ];
    }
}
