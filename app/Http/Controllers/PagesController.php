<?php

namespace App\Http\Controllers;

use App\Models\Title;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Helpers\Traits\SearchHelpers;

class PagesController extends Controller
{
	use SearchHelpers;

	/**
	 * Returns home page view
	 */
	public function home()
	{
		$random_recipes = Recipe::inRandomOrder()
			->where("ready_" . locale(), 1)
			->where("approved_" . locale(), 1)
			->limit(12)
			->get([
				'id', 'title_' . locale(),
				"intro_" . locale(), 'image'
			]);

		$intro = Title::whereName("intro")->first([
			'title_' . locale(),
			'text_' . locale()
		]);

		return view('pages.home', [
			'random_recipes' => $random_recipes,
			'intro' => $intro
		]);
	}

	/**
	 * @param Request $request
	 */
	public function search(Request $request)
    {
		if (request('for')) {
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

		return view('pages.search', compact('recipes', 'message'));
	}
}
