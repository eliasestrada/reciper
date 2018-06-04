<?php

namespace App\Http\Controllers;

use Schema;
use App\Models\Meal;
use App\Models\Trans\Title;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\Traits\CommonHelper;


class PagesController extends Controller
{
	use CommonHelper;

	public function home()
	{
		if (Schema::hasTable('recipes_' . locale())) {
			$random_recipes = Recipe::inRandomOrder()
				->whereApproved(1)->limit(12)
				->get([ 'id', 'title', 'image' ]);
		}

		if (Schema::hasTable('titles_ru')) {
			$title_intro = Title::where('name', 'Интро')->first([ 'title', 'text' ]);
		}

		return view('pages.home')->with(compact(
			'random_recipes', 'title_intro'
		));
	}


	public function search(Request $request)
    {
		if ($this->checkIfTableExists('recipes_' . locale())) {
			return view('pages.search')->withError(trans('message.fail_connection'));
		}

		$meal_time = [
			mb_strtolower(trans('header.breakfast')),
			mb_strtolower(trans('header.lunch')),
			mb_strtolower(trans('header.dinner'))
		];

		if ($request = mb_strtolower($request->input('for'))) {
			if (in_array($request, $meal_time)) {
				// Search for meal time
				$recipes = Meal
					::where('name_' . locale(), 'LIKE', '%'.$request.'%')
					->with('recipes_' . locale())
					->take(50)
					->get();
			} else {
				// Search for categories
				$request = str_replace('-', ' ', $request);
				$recipes = Category
					::where('name_' . locale(), 'LIKE', '%'.$request.'%')
					->with('recipes_' . locale())
					->take(50)
					->get();
			}

			if ($recipes->count() > 0) {
				$recipes = $recipes[0]->recipes;
			} else {
				// Search for recipes
				$recipes = Recipe
					::where('title', 'LIKE', '%'.$request.'%')
					->orWhere('ingredients', 'LIKE', '%'.$request.'%')
					->take(50)
					->get();
			}

			$message = count($recipes) < 1 ? trans('pages.nothing_found') : '';
		} else {
			$recipes = '';
			$message = trans('pages.use_search');
		}

		return view('pages.search')->with(compact('recipes', 'message'));
	}
}
