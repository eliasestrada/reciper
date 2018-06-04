<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Title;
use App\Models\Recipe;
use Illuminate\Http\Request;


class PagesController extends Controller
{
	public function home()
	{
		$random_recipes = Recipe::inRandomOrder()
			->whereApproved(1)->limit(12)
			->get([ 'id', 'title', 'image' ]);

		$meal = Meal::get();

		return view('pages.home')->with(compact(
			'random_recipes', 'title_intro', 'meal'
		));
	}


	public function search(Request $request)
    {
		if ($request = $request->input('for')) {
			if (is_numeric($request)) {
				$query = Recipe::query()
					->whereCategoryId($request);
			} else {
				$query = Recipe::query()
					->where('title', 'LIKE', '%' . $request . '%')
					->orWhere('ingredients', 'LIKE', '%' . $request . '%');
			}
			$recipes = $query->take(50)->get();
			$message = count($recipes) < 1 ? trans('pages.nothing_found') : '';
		} else {
			$recipes = '';
			$message = trans('pages.use_search');
		}

		return view('pages.search')->with(compact('recipes', 'message'));
	}
}
