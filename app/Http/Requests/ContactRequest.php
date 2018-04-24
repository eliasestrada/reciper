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
            'name'			 => 'required|min:3|max:50',
			'email'			 => 'required|email',
			'message'		 => 'required|min:20|max:5000'
        ];
	}
	
	public function messages()
    {
        return [
			'name.required'      	=> trans('my_valid.contact_name_required'),
			'email.required'  		=> trans('my_valid.contact_email_required'),
			'message.required' 		=> trans('my_valid.contact_message_required'),
			'email.email' 			=> trans('my_valid.contact_email_email'),
			'message.min' 			=> trans('my_valid.contact_message_min'),
			'message.max' 			=> trans('my_valid.contact_message_max')
		];
    }
}
