<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRecipeRequest extends FormRequest
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
        $min = config('validation.report_message_min');
        $max = config('validation.report_message_max');

        return [
            'message' => "required|min:$min|max:$max",
            'recipe' => 'required|numeric',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'message_required' => trans('report.message_required'),
            'message_min' => trans('report.message_min'),
            'message_max' => trans('report.message_max'),
        ];
    }
}
