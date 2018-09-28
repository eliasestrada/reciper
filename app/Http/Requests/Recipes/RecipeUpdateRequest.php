<?php

namespace App\Http\Requests\Recipes;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class RecipeUpdateRequest extends FormRequest
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
        $title_min = config('validation.recipes.title.min');
        $title_max = config('validation.recipes.title.max');
        $intro_min = config('validation.recipes.intro.min');
        $intro_max = config('validation.recipes.intro.max');
        $ingredients_min = config('validation.recipes.ingredients.min');
        $ingredients_max = config('validation.recipes.ingredients.max');
        $text_min = config('validation.recipes.text.min');
        $text_max = config('validation.recipes.text.max');

        if ($this->ready == 1) {
            return [
                'title' => "min:$title_min|max:$title_max",
                'intro' => "min:$intro_min|max:$intro_max",
                'ingredients' => "min:$ingredients_min|max:$ingredients_max",
                'text' => "min:$text_min|max:$text_max",
                'meal' => 'numeric|between:1,3',
                'time' => 'numeric|between:1,1000',
                'image' => 'image|nullable|max:1999',
                'categories.0' => 'required',
                'categories.*' => 'distinct|numeric|between:1,' . Category::count(),
            ];
        }
        return [];
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
            'image.max' => trans('recipes.image_max'),
        ];
    }
}