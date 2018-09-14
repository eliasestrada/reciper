<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveMessageRequest;
use App\Models\Recipe;

class ApprovesController extends Controller
{

    /**
     * Shows all recipes that need to be approved
     * by administration
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unapproved = Recipe::oldest()
            ->approved(0)
            ->ready(1)
            ->paginate(30)
            ->onEachSide(1);

        return view('admin.approves.index', compact('unapproved'));
    }

    /**
     * @param Recipe $recipe
     */
    public function ok(Recipe $recipe, ApproveMessageRequest $request)
    {
        if ($recipe->isDone()) {
            return back()->withError(trans('approves.already_approved'));
        }

        if (!$recipe->isReady() && !$recipe->isApproved()) {
            return back()->withError(trans('approves.recipe_in_drafts'));
        }

        cache()->forget('all_unapproved');
        cache()->forget('search_suggest');

        $rand = rand(1, 5);
        $message = $request->message == 'ok' ? trans("approves.approved_$rand") : $request->message;

        event(new \App\Events\RecipeGotApproved($recipe, $message));

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
