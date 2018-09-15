<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveMessageRequest extends FormRequest
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
        $max = config('validation.approve_message');

        return request()->message == 'ok' ? [] : [
            'message' => "required|min:30|max:$max",
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'message.required' => trans('notifications.message_required'),
            'message.min' => trans('notifications.message_min'),
            'message.max' => trans('notifications.message_max'),
        ];
    }
}
