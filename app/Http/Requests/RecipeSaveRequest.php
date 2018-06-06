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
            'title' => 'max:190',
            'intro' => 'max:2000',
            'ingredients'  => 'max:5000',
			'text' => 'max:10000',
			'meal' => 'numeric|digits_between:1,3',
            'time' => 'numeric|digits_between:0,1999',
            'image' => 'image|nullable|max:1999'
        ];
	}

    public function messages()
    {
        return [
            'title.min' => trans('recipes.title_min'),
			'title.max' => trans('recipes.title_max'),

			'intro.min' => trans('recipes.intro_max'),
			'intro.max' => trans('recipes.intro_max'),

			'ingredients.min' => trans('recipes.ingredients_min'),
			'ingredients.max' => trans('recipes.ingredients_max'),

			'text.min' => trans('recipes.text_min'),
			'text.max' => trans('recipes.text_max'),

			'meal.numeric' => trans('recipes.meal_numeric'),
			'meal.digits_between' => trans('recipes.meal_digits_between'),

			'time.numeric' => trans('recipes.time_numeric'),
			'time.digits_between' => trans('recipes.time_digits_between'),

			'image.image' => trans('recipes.image_image'),
			'image.max' => trans('recipes.image_max')
        ];
    }
}
