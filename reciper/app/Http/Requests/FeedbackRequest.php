<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
        $min = config('valid.feedback.contact.message.min');
        $max = config('valid.feedback.contact.message.max');

        return [
            'email' => request()->has('email') ? 'required|email' : 'nullable',
            'message' => "required|min:{$min}|max:{$max}",
            'recipe_id' => 'nullable|numeric',
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
            'message.required' => trans('contact.contact_message_required'),
            'email.required' => trans('contact.contact_email_required'),
            'email.email' => trans('contact.contact_email_email'),
            'message.min' => trans('contact.contact_message_min'),
            'message.max' => trans('contact.contact_message_max'),
        ];
    }
}
