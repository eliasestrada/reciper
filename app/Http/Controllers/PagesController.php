<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Recipe;
use App\Title;

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

		$title_banner = Title::select(['title', 'text'])
				->where('name', 'Баннер')
				->first();

		$title_intro = Title::select(['title', 'text'])
				->where('name', 'Интро')
				->first();

		$icon = 'M244.186,214.604l-54.379-54.378c-0.289-0.289-0.628-0.491-0.93-0.76
		c10.7-16.231,16.945-35.66,16.945-56.554C205.822,46.075,159.747,0,102.911,0S0,46.075,0,102.911
		c0,56.835,46.074,102.911,102.91,102.911c20.895,0,40.323-6.245,56.554-16.945c0.269,0.301,0.47,0.64,0.759,0.929l54.38,54.38 c8.169,8.168,21.413,8.168,29.583,0C252.354,236.017,252.354,222.773,244.186,214.604z M102.911,170.146 c-37.134,0-67.236-30.102-67.236-67.235c0-37.134,30.103-67.236,67.236-67.236c37.132,0,67.235,30.103,67.235,67.236 C170.146,140.044,140.043,170.146,102.911,170.146z"';

		return view('pages.home')
				->with([
					'random_recipes' => $random_recipes,
					'title_banner' => $title_banner,
					'title_intro' => $title_intro,
					'icon' => $icon
				]);
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
					->with([
						'recipes' => $recipes,
						'message' => $message
					]);
	}
}