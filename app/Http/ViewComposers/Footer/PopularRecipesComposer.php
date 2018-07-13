<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Recipe;
use Illuminate\View\View;

class PopularRecipesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) : void
    {
		$popular_recipes = Recipe
			::select('id', 'title_' . locale())
			->withCount('likes')
			->orderBy('likes_count', 'desc')
			->where('ready_' . locale(), 1)
			->where('approved_' . locale(), 1)
			->limit(10)
			->get();

		$view->with(compact('popular_recipes'));
    }
}