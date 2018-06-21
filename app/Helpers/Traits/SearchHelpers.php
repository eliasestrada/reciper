<?php

namespace App\Helpers\Traits;

use App\Models\Meal;
use App\Models\Recipe;
use App\Models\Category;

trait SearchHelpers
{
	/**
	 * @param string $request
	 * @return object|array
	 */
	public function searchForCategories($request)
	{
		$request = str_replace('-', ' ', $request);
		$category = Category
			::where('name_' . locale(), 'LIKE', '%' . $request . '%')
			->with('recipes')
			->take(50)
			->get();

		return count($category) > 0
			? $category[0]->recipes
				->where('ready_' . locale(), 1)
				->where('approved_' . locale(), 1)
			: [];
	}

	/**
	 * @param string $request
	 * @return object|array
	 */
	public function searchForMealTime($request)
	{
		$meal =  Meal
			::where('name_' . locale(), 'LIKE', '%' . $request . '%')
			->with('recipes')
			->take(50)
			->get();

		return count($meal) > 0
			? $meal[0]->recipes
				->where('ready_' . locale(), 1)
				->where('approved_' . locale(), 1) 
			: [];
	}

	/**
	 * @param string $request
	 * @return object
	 */
	public function searchForRecipes($request) : ? object
	{
		return Recipe
			::where('title_' . locale(), 'LIKE', '%' . $request . '%')
			->orWhere('ingredients_' . locale(), 'LIKE', '%' . $request . '%')
			->take(50)
			->get()
			->where('ready_' . locale(), 1)
			->where('approved_' . locale(), 1);
	}

	/**
	 * @return array
	 */
	public function mealTime() : array
	{
		return [
			trans('header.breakfast'),
			trans('header.lunch'),
			trans('header.dinner')
		];
	}
}