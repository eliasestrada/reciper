<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveMessageRequest;
use App\Models\Recipe;
use App\Models\User;

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
        $unapproved_waiting = Recipe::oldest()
            ->whereApproverId(0)
            ->approved(0)
            ->ready(1)
            ->paginate(30)
            ->onEachSide(1);

        $unapproved_checking = Recipe::oldest()
            ->where('approver_id', '!=', 0)
            ->approved(0)
            ->ready(1)
            ->paginate(30)
            ->onEachSide(1);

        // Check if admin is already has recipe that he didnt approved
        $already_checking = Recipe::whereApproverId(user()->id)->approved(0)->ready(1)->value('id');

        if ($already_checking) {
            return redirect("/admin/approves/$already_checking")->withSuccess(
                trans('approves.finish_checking')
            );
        }

        return view('admin.approves.index', compact(
            'unapproved_waiting', 'unapproved_checking'
        ));
    }

    /**
     * @param Recipe $recipe
     */
    public function show(Recipe $recipe)
    {
        // Check if u can work with the recipe
        if (($error = $this->hasErrors($recipe)) !== false) {
            return redirect("/admin/approves")->withError($error);
        }

        if (!$recipe->approver_id) {
            $recipe->update(['approver_id' => user()->id]);
        }

        return view('admin.approves.show', compact('recipe'));
    }

    /**
     * @param Recipe $recipe
     */
    public function ok(Recipe $recipe, ApproveMessageRequest $request)
    {
        // Check if u can work with the recipe
        if (($error = $this->hasErrors($recipe)) !== false) {
            return redirect("/admin/approves")->withError($error);
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
        // Check if u can work with the recipe
        if (($error = $this->hasErrors($recipe)) !== false) {
            return redirect("/admin/approves")->withError($error);
        }

        cache()->forget('all_unapproved');
        cache()->forget('search_suggest');

        event(new \App\Events\RecipeGotCanceled($recipe, $request->message));

        $recipe->decrement('ready_' . lang());

        return redirect('/recipes')->withSuccess(
            trans('recipes.you_gave_recipe_back_on_editing')
        );
    }

    /**
     * Checks if recipe not approved and ready
     * @param $recipe
     */
    public function hasErrors($recipe)
    {
        if ($recipe->isDone()) {
            return trans('approves.already_approved');
        }

        if (!$recipe->isReady() && !$recipe->isApproved()) {
            return trans('recipes.not_written');
        }
        return false;
    }
}
