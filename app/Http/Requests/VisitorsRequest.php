<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $min = config('validation.ban_message_min');
        $max = config('validation.ban_message_max');

        return [
            'days' => 'required|numeric',
            'message' => "required|min:$min|max:$max",
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'days.required' => trans('visitors.days_required'),
            'days.numeric' => trans('visitors.days_numeric'),
            'message.required' => trans('visitors.message_required'),
            'message.min' => trans('visitors.message_min'),
            'message.max' => trans('visitors.message_max'),
        ];
    }
}
