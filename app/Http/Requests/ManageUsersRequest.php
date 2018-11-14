<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageUsersRequest extends FormRequest
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
        $min = config('valid.feedback.ban.message.min');
        $max = config('valid.feedback.ban.message.max');

        return [
            'days' => 'required|numeric',
            'message' => "required|min:$min|max:$max",
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
            'days.required' => trans('manage-users.days_required'),
            'days.numeric' => trans('manage-users.days_numeric'),
            'message.required' => trans('manage-users.message_required'),
            'message.min' => trans('manage-users.message_min'),
            'message.max' => trans('manage-users.message_max'),
        ];
    }
}
