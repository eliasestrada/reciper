<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveMessageRequest;
use App\Models\Notification;
use App\Models\Recipe;

class ApproveController extends Controller
{
    /**
     * @param Recipe $recipe
     */
    public function ok(Recipe $recipe, ApproveMessageRequest $request)
    {
        $this->forgetCache();

        event(new \App\Events\RecipeGotApproved($recipe));

        Notification::sendToUser(
            'recipe_published',
            $request->message,
            $recipe->getTitle(),
            $recipe->user_id
        );

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
        $this->forgetCache();

        Notification::sendToUser(
            'recipe_not_published',
            $request->message,
            $recipe->getTitle(),
            $recipe->user_id
        );

        $recipe->decrement('ready_' . lang());

        return redirect('/recipes')->withSuccess(
            trans('recipes.you_gave_recipe_back_on_editing')
        );
    }

    /**
     * @return void
     */
    public function forgetCache(): void
    {
        cache()->forget('all_unapproved');
        cache()->forget('all_notifs');
        cache()->forget('search_suggest');
    }
}
