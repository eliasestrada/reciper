<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        $title_max = config('valid.docs.title.max');
        $title_min = config('valid.docs.title.min');
        $text_max = config('valid.docs.text.max');
        $text_min = config('valid.docs.text.min');

        return [
            'title' => "required|min:{$title_min}|max:{$title_max}",
            'text' => "required|min:{$text_min}|max:{$text_max}",
        ];
    }

    /**
     * Get the validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => trans('documents.title_required'),
            'title.min' => trans('documents.title_min'),
            'title.max' => trans('documents.title_max'),
            'text.required' => trans('documents.text_required'),
            'text.min' => trans('documents.text_min'),
            'text.max' => trans('documents.text_max'),
        ];
    }
}
