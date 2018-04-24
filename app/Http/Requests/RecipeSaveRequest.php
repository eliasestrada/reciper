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
            'title'        => 'max:199',
            'intro'        => 'max:2000',
            'ingredients'  => 'max:5000',
            'advice'       => 'max:5000',
            'text'         => 'max:10000',
            'time'         => 'numeric|digits_between:0,1999',
            'image'        => 'image|nullable|max:1999'
        ];
	}

    public function messages()
    {
        return [
            'title.min'             => trans('my_valid.recipe_min'),
			'title.max'             => trans('my_valid.recipe_title_max'),
			'intro.min'             => trans('my_valid.recipe_intro_max'),
			'intro.max'             => trans('my_valid.recipe_intro_max'),
			'ingredients.min'       => trans('my_valid.recipe_ingredients_min'),
			'ingredients.max'       => trans('my_valid.recipe_ingredients_max'),
			'advice.max'            => trans('my_valid.recipe_advice_max'),
			'text.min'              => trans('my_valid.recipe_text_min'),
			'text.max'              => trans('my_valid.recipe_text_max'),
			'time.numeric'          => trans('my_valid.recipe_time_numeric'),
			'time.digits_between'   => trans('my_valid.recipe_digits_between'),
			'image.image'           => trans('my_valid.recipe_image_image'),
			'image.max'             => trans('my_valid.recipe_image_max')
        ];
    }
}
