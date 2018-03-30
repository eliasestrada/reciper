<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Recipe;

class PagesController extends Controller
{
	/* HOME
	====================== */

    public function home() {

		$random_recipes = Recipe::inRandomOrder()
				->select(['id', 'title', 'image'])
				->where('approved', 1)
				->limit(9)
				->get();

		$title_banner = DB::table('titles')
				->select(['title', 'text'])
				->where('name', 'Баннер')
				->first();

		$title_intro = DB::table('titles')
				->select(['title', 'text'])
				->where('name', 'Интро')
				->first();

		return view('pages.home')
				->with('random_recipes', $random_recipes)
				->with('title_banner', $title_banner)
				->with('title_intro', $title_intro);
	}

	/* SEARCH
	====================== */

	public function search(Request $request)
    {
		$query = $request->input('for');

		if ($query) {
			$recipes = Recipe::where('title', 'LIKE', '%' . $query . '%')
					->orWhere('ingredients', 'LIKE', '%' . $query . '%')
					->orWhere('category', 'LIKE', '%' . $query . '%')
					->paginate(20);
			$message = count($recipes) < 1 ? 'Ничего не найденно' : '';
		} else {
			$recipes = '';
			$message = 'Воспользуйтесь поиском чтобы найти рецепты, ингридиенты или категории.';
		}
		return view('pages.search')
					->with('recipes', $recipes)
					->with('message', $message);
	}
}