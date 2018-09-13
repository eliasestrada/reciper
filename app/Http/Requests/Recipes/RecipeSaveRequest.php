<?php

namespace App\Http\Requests\Recipes;

use Illuminate\Foundation\Http\FormRequest;

class RecipeSaveRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation messages that apply to the request.
    public function rules()
    {
        return [
            'title' => 'min:5|max:' . config('validation.recipe_title_max'),
        ];
    }

    public function messages()
    {
        return [
            'title.min' => trans('recipes.title_min'),
            'title.max' => trans('recipes.title_max'),
        ];
    }
}
