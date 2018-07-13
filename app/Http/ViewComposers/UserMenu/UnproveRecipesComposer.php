<?php

namespace App\Http\ViewComposers\UserMenu;

use App\Models\Recipe;
use Illuminate\View\View;

class UnproveRecipesComposer
{
    /**
     * Bind data to the view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) : void
    {
		if (user()) {
			$recipes = Recipe::where("approved_" . locale(), 0)
				->where("ready_" . locale(), 1)
				->count();

			$view->with('all_unapproved', getDataNotifMarkup($recipes));
		}
    }
}