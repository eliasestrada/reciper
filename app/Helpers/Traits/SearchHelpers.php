<?php

namespace App\Helpers\Traits;

use App\Models\Meal;
use App\Models\Recipe;
use App\Models\Category;

trait SearchHelpers
{
	public function searchForCategories($request)
	{
		$request = str_replace('-', ' ', $request);
		$category = Category
			::where('name_' . locale(), 'LIKE', '%' . $request . '%')
			->with('recipes')
			->take(50)
			->get();

		return count($category) > 0 ? $category[0]->recipes : [];
	}


	public function searchForMealTime($request)
	{
		$meal =  Meal
			::where('name_' . locale(), 'LIKE', '%' . $request . '%')
			->with('recipes')
			->take(50)
			->get();

		return count($meal) > 0 ? $meal[0]->recipes : [];
	}


	public function searchForRecipes($request)
	{
		return Recipe
			::where('title_' . locale(), 'LIKE', '%' . $request . '%')
			->orWhere('ingredients_' . locale(), 'LIKE', '%' . $request . '%')
			->take(50)
			->get();
	}


	public function mealTime() {
		return [
			trans('header.breakfast'),
			trans('header.lunch'),
			trans('header.dinner')
		];
	}
}