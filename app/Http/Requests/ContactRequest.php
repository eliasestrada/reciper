<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'message' => 'required|
				min:' . config('validation.contact_message_min') . '|
				max:' . config('validation.contact_message_max'),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => trans('contact.contact_email_required'),
            'message.required' => trans('contact.contact_message_required'),
            'email.email' => trans('contact.contact_email_email'),
            'message.min' => trans('contact.contact_message_min'),
            'message.max' => trans('contact.contact_message_max'),
        ];
    }
}
