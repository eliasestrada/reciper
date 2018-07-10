<?php

namespace App\Http\ViewComposers\UserMenu;

use Schema;
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
		if (Schema::hasTable('recipes')) {
			if (user()) {
				$recipes = Recipe::where("approved_" . locale(), 0)
					->where("ready_" . locale(), 1)
					->count();
	
				$view->with('all_unapproved', getDataNotifMarkup($recipes));
			}
		} else {
			logger()->emergency("Table recipes wasn't found while trying to count all unproved recipes, name of the method: countAndComposeAllUnprovedRecipes");
		}
    }
}