<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveMessageRequest;
use App\Models\Recipe;

class ApproveController extends Controller
{
    /**
     * @param Recipe $recipe
     */
    public function ok(Recipe $recipe, ApproveMessageRequest $request)
    {
        cache()->forget('all_unapproved');
        cache()->forget('search_suggest');

        event(new \App\Events\RecipeGotApproved($recipe, $request->message));

        $recipe->increment('approved_' . lang());

        return redirect('/recipes')->withSuccess(
            trans("recipes.recipe_published")
        );
    }

    /**
     * Approve the recipe (for admins)
     * @param Recipe $recipe
     */
    public function cancel(Recipe $recipe, ApproveMessageRequest $request)
    {
        cache()->forget('all_unapproved');
        cache()->forget('search_suggest');

        event(new \App\Events\RecipeGotCanceled($recipe, $request->message));

        $recipe->decrement('ready_' . lang());

        return redirect('/recipes')->withSuccess(
            trans('recipes.you_gave_recipe_back_on_editing')
        );
    }
}
