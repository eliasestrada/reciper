<?php

namespace App\Http\Requests\Recipes;

use Illuminate\Foundation\Http\FormRequest;

class RecipeStoreRequest extends FormRequest
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
        $min = config('valid.recipes.title.min');
        $max = config('valid.recipes.title.max');

        return ['title' => "required|min:{$min}|max:{$max}"];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => trans('recipes.title_required'),
            'title.min' => trans('recipes.title_min'),
            'title.max' => trans('recipes.title_max'),
        ];
    }
}
