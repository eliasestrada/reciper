<?php

namespace App\Http\Requests;

use App\Models\HelpCategory;
use Illuminate\Foundation\Http\FormRequest;

class HelpRequest extends FormRequest
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
        $title_min = config('valid.help.title.min');
        $title_max = config('valid.help.title.max');
        $text_min = config('valid.help.text.min');
        $text_max = config('valid.help.text.max');
        $last_number = HelpCategory::count();

        return [
            'title' => "required|min:{$title_min}|max:{$title_max}",
            'text' => "required|min:{$text_min}|max:{$text_max}",
            'category' => "required|numeric|between:1,{$last_number}",
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
            'title.required' => trans('help.title_required'),
            'title.min' => trans('help.title_min'),
            'title.max' => trans('help.title_max'),
            'text.required' => trans('help.text_required'),
            'text.min' => trans('help.text_min'),
            'text.max' => trans('help.text_max'),
            'category.required' => trans('help.category_required'),
            'category.numeric' => trans('help.category_numeric'),
            'category.between' => trans('help.category_between'),
        ];
    }
}
