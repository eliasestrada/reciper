<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisapproveRequest extends FormRequest
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
        $min = config('valid.approves.disapprove.message.min');
        $max = config('valid.approves.disapprove.message.max');

        return ['message' => "required|min:{$min}|max:{$max}"];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'message.required' => trans('approves.message_required'),
            'message.min' => trans('approves.message_min'),
            'message.max' => trans('approves.message_max'),
        ];
    }
}
