<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Recipe;

class ApproveController extends Controller
{
    /**
     * @param Recipe $recipe
     */
    public function ok(Recipe $recipe)
    {
        Notification::sendMessage(
            'recipe_published',
            'recipe_with_title_published',
            $recipe->getTitle(),
            $recipe->user_id
        );

        $recipe->increment('approved_' . locale());

        return redirect('/recipes')->withSuccess(
            trans('recipes.recipe_published')
        );
    }

    /**
     * Approve the recipe (for admins)
     * @param Recipe $recipe
     */
    public function cancel(Recipe $recipe)
    {
        Notification::sendMessage(
            'recipe_not_published',
            'recipe_with_title_not_published',
            $recipe->getTitle(),
            $recipe->user_id
        );

        $recipe->decrement('ready_' . locale());

        return redirect('/recipes')->withSuccess(
            trans('recipes.you_gave_recipe_back_on_editing')
        );

    }
}
