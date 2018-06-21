<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Notification;

class ApproveController extends Controller
{
	public function ok(Recipe $recipe)
	{
		Notification::sendMessage(
			'notifications.recipe_published',
			'notifications.recipe_with_title_published',
			$recipe->user_id,
			'"' . $recipe->getTitle() . '"',
		0, 0);

		$recipe->increment('approved_' . locale());

		return redirect('/recipes')->withSuccess(
			trans('recipes.recipe_published')
		);
	}

    // Approve the recipe (for admins)
    public function cancel(Recipe $recipe)
    {
		Notification::sendMessage(
			'notifications.recipe_not_published',
			'notifications.recipe_with_title_not_published',
			$recipe->user_id,
			'"' . $recipe->getTitle() . '"',
		0, 0);

		$recipe->decrement('ready_' . locale());

		return redirect('/recipes')->withSuccess(
			trans('recipes.you_gave_recipe_back_on_editing')
		);

    }
}
