<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Notification;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
	public function ok(Recipe $recipe)
	{
		Notification::recipeHasBeenApproved(
			$recipe->title, $recipe->user_id
		);
		$recipe->increment('approved');

		return redirect('/recipes')->withSuccess(
			trans('recipes.recipe_is_published')
		);
	}

    // Approve the recipe (for admins)
    public function cancel(Recipe $recipe)
    {
		Notification::recipeHasNotBeenCreated(
			$recipe->title, $recipe->user_id
		);

		$recipe->decrement('ready');

		return redirect('/recipes')->withSuccess(
			trans('recipes.you_gave_recipe_back_on_editing')
		);

    }
}
