<?php

namespace App\Http\Requests\Settings;

use App\Models\Category;
use App\Rules\UniqueCategory;
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
				'title' => 'min:5|max:'  . config('validation.title_max'),
				'intro' => 'min:20|max:' . config('validation.intro_max'),
				'ingredients' => 'min:20|max:' . config('validation.ingredients_max'),
				'text' => 'min:80|max:' . config('validation.text_max'),
				'meal' => 'numeric|between:1,3',
				'time' => 'numeric|between:0,1000',
				'image' => 'image|nullable|max:1999',
				'categories.0' => 'required',
				'categories.*' => 'distinct|numeric|between:1,' . Category::count(),
			];
		}
		return [
			'categories.0' => 'required',
			'categories.*' => 'distinct|numeric|between:1,' . Category::count(),
		];
	}
	
	// Get the validation messages that apply to the request.
    public function messages()
    {
		return [
			'title.min' => trans('recipes.title_min'),
			'title.max' => trans('recipes.title_max'),

			'intro.min' => trans('recipes.intro_min'),
			'intro.max' => trans('recipes.intro_max'),

			'meal.numeric' => trans('recipes.meal_numeric'),
			'meal.between' => trans('recipes.meal_between'),

			'ingredients.min' => trans('recipes.ingredients_min'),
			'ingredients.max' => trans('recipes.ingredients_max'),

			'categories.0.required' => trans('recipes.categories_required'),
			'categories.*.distinct' => trans('recipes.categories_distinct'),
			'categories.*.numeric' => trans('recipes.categories_numeric'),
			'categories.*.between' => trans('recipes.categories_numeric'),

			'text.min' => trans('recipes.text_min'),
			'text.max' => trans('recipes.text_max'),

			'time.numeric' => trans('recipes.time_numeric'),
			'time.between' => trans('recipes.time_between'),

			'image.image' => trans('recipes.image_image'),
			'image.max' => trans('recipes.image_max')
		];
    }
}
