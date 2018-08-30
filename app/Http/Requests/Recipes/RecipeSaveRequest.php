<?php

namespace App\Http\Requests\Recipes;

use App\Models\Category;
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
            'title' => 'max:' . config('validation.recipe_title_max'),
            'intro' => 'max:' . config('validation.recipe_intro_max'),
            'ingredients' => 'max:' . config('validation.recipe_ingredients_max'),
            'text' => 'max:' . config('validation.recipe_text_max'),
            'meal' => 'numeric|between:1,3',
            'time' => 'numeric|between:0,1999',
            'image' => 'image|nullable|max:1999',
            'categories.0' => 'required',
            'categories.*' => 'distinct|numeric|between:1,' . Category::count(),
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
            'meal.between' => trans('recipes.meal_between'),

            'categories.0.required' => trans('recipes.categories_required'),
            'categories.*.distinct' => trans('recipes.categories_distinct'),
            'categories.*.numeric' => trans('recipes.categories_numeric'),
            'categories.*.between' => trans('recipes.categories_numeric'),

            'time.numeric' => trans('recipes.time_numeric'),
            'time.between' => trans('recipes.time_between'),

            'image.image' => trans('recipes.image_image'),
            'image.max' => trans('recipes.image_max'),
        ];
    }
}
