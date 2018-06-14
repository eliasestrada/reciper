<?php

namespace App\Http\Controllers;

use Schema;
use App\Models\Title;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Helpers\Traits\SearchHelpers;


class PagesController extends Controller
{
	use SearchHelpers;

	public function home()
	{
		if (Schema::hasTable('recipes')) {
			$random_recipes = Recipe
				::inRandomOrder()
				->where("ready_" . locale(), 1)
				->where("approved_" . locale(), 1)
				->limit(12)
				->get(['id', "title_" . locale(), 'image']);
		}

		if (Schema::hasTable('titles')) {
			$intro = Title::whereName("intro");

			$title_intro = $intro->value("title_" . locale());
			$text_intro = $intro->value("text_" . locale());
		}

		return view('pages.home')->with(compact(
			'random_recipes', 'title_intro', 'text_intro'
		));
	}


	public function search(Request $request)
    {
		if (request('for') && Schema::hasTable('recipes')) {
			$request = mb_strtolower(request('for'));

			if (in_array($request, $this->mealTime())) {
				$recipes = $this->searchForMealTime($request);
			} else {
				$recipes = $this->searchForCategories($request);
			}

			if (count($recipes) === 0) {
				// If no recipes found, search for recipe title or intro
				$recipes = $this->searchForRecipes($request);
				$message = count($recipes) > 0 ? '' : trans('pages.nothing_found');
			}
		} else {
			$message = trans('pages.use_search');
		}

		return view('pages.search')->with(compact('recipes', 'message'));
	}
}
