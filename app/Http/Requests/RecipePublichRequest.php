<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipePublichRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

	/**
	 * Get the validation rules that apply to the request, 
	 * only if recipe is ready to publish
	 */
    public function rules()
    {
        if ($this->ready == 1) {
			return [
				'title' => 'min:5|max:190',
				'intro' => 'min:20|max:2000',
				'ingredients' => 'min:20|max:5000',
				'text' => 'min:80|max:10000',
				'time' => 'numeric|digits_between:0,1000',
				'image' => 'image|nullable|max:1999'
			];
		}
		return [];
	}
	
	// Get the validation messages that apply to the request.
    public function messages()
    {
        if ($this->ready == 1) {
			return [
				'title.min' => trans('recipes.recipe_min'),
				'title.max' => trans('recipes.recipe_title_max'),
				'intro.min' => trans('recipes.recipe_intro_min'),
				'intro.max' => trans('recipes.recipe_intro_max'),
				'ingredients.min' => trans('recipes.recipe_ingredients_min'),
				'ingredients.max' => trans('recipes.recipe_ingredients_max'),
				'text.min' => trans('recipes.recipe_text_min'),
				'text.max' => trans('recipes.recipe_text_max'),
				'time.numeric' => trans('recipes.recipe_time_numeric'),
				'time.digits_between' => trans('recipes.recipe_digits_between'),
				'image.image' => trans('recipes.recipe_image_image'),
				'image.max' => trans('recipes.recipe_image_max')
			];
		}
		return [];
    }
}
