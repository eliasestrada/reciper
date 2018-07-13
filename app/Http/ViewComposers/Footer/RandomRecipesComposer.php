<?php

namespace App\Http\ViewComposers\Footer;

use App\Models\Recipe;
use Illuminate\View\View;

class RandomRecipesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) : void
    {
		$rand_recipes = Recipe
			::inRandomOrder()
			->where("approved_" . locale(), 1)
			->limit(20)
			->get([ 'id', "title_" . locale() ]);

			$view->with(compact('rand_recipes'));
    }
}