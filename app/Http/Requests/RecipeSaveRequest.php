<?php

namespace App\Http\Requests;

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
            'title' => 'max:199',
            'intro' => 'max:2000',
            'ingredients'  => 'max:5000',
            'advice' => 'max:5000',
            'text' => 'max:10000',
            'time' => 'numeric|digits_between:0,1999',
            'image' => 'image|nullable|max:1999'
        ];
	}

    public function messages()
    {
        return [
            'title.min' => trans('recipes.recipe_min'),
			'title.max' => trans('recipes.recipe_title_max'),
			'intro.min' => trans('recipes.recipe_intro_max'),
			'intro.max' => trans('recipes.recipe_intro_max'),
			'ingredients.min' => trans('recipes.recipe_ingredients_min'),
			'ingredients.max' => trans('recipes.recipe_ingredients_max'),
			'advice.max' => trans('recipes.recipe_advice_max'),
			'text.min' => trans('recipes.recipe_text_min'),
			'text.max' => trans('recipes.recipe_text_max'),
			'time.numeric' => trans('recipes.recipe_time_numeric'),
			'time.digits_between'   => trans('recipes.recipe_digits_between'),
			'image.image' => trans('recipes.recipe_image_image'),
			'image.max' => trans('recipes.recipe_image_max')
        ];
    }
}
