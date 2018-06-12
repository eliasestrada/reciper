<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Notification;

class ApproveController extends Controller
{
	public function ok(Recipe $recipe)
	{
		Notification::recipeHasBeenApproved(
			$recipe->getTitle(), $recipe->user_id
		);
		$recipe->increment('approved_' . locale());

		return redirect('/recipes')->withSuccess(
			trans('recipes.recipe_published')
		);
	}

    // Approve the recipe (for admins)
    public function cancel(Recipe $recipe)
    {
		Notification::recipeHasNotBeenCreated(
			$recipe->getTitle(), $recipe->user_id
		);

		$recipe->decrement('ready_' . locale());

		return redirect('/recipes')->withSuccess(
			trans('recipes.you_gave_recipe_back_on_editing')
		);

    }
}
