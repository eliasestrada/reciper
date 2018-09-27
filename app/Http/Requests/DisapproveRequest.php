<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisapproveRequest extends FormRequest
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
        $min = config('validation.disapprove_message_min');
        $max = config('validation.disapprove_message_max');

        return ['message' => "required|min:$min|max:$max"];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'message.required' => trans('approves.message_required'),
            'message.min' => trans('approves.message_min'),
            'message.max' => trans('approves.message_max'),
        ];
    }
}
