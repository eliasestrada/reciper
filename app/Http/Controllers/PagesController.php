<?php

namespace App\Http\Controllers;

use App\Models\Title;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Helpers\Traits\CommonHelper;
use Illuminate\Support\Facades\Schema;

class PagesController extends Controller
{
	use CommonHelper;

	public function home()
	{
		if (Schema::hasTable('recipes')) {
			$random_recipes = Recipe::inRandomOrder()
				->whereApproved(1)->limit(12)
				->get([ 'id', 'title', 'image' ]);
		}

		if (Schema::hasTable('titles')) {
			$title_banner = Title::whereName('Баннер')->first([ 'title', 'text' ]);
			$title_intro = Title::whereName('Интро')->first([ 'title', 'text' ]);
		}

		return view('pages.home')->with(compact(
			'random_recipes', 'title_banner', 'title_intro'
		));
	}


	public function search(Request $request)
    {
		if ($this->checkIfTableExists('recipes')) {
			return view('pages.search')->withError(trans('message.fail_connection'));
		}

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