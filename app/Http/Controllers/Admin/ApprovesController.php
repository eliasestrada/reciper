<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisapproveRequest;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;

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
            ->where(LANG() . '_approver_id', 0)
            ->selectBasic()
            ->approved(0)
            ->ready(1)
            ->paginate(30)
            ->onEachSide(1);

        $unapproved_checking = Recipe::oldest()
            ->where(LANG() . '_approver_id', '!=', 0)
            ->selectBasic()
            ->approved(0)
            ->ready(1)
            ->paginate(30)
            ->onEachSide(1);

        $my_approves = Recipe::oldest()
            ->where(LANG() . '_approver_id', user()->id)
            ->done(1)
            ->paginate(30)
            ->onEachSide(1);

        // Check if admin is already has recipe that he didnt approved
        $already_checking = Recipe::where(LANG() . '_approver_id', user()->id)->approved(0)->ready(1)->value('id');

        if ($already_checking) {
            return redirect("/admin/approves/$already_checking")->withSuccess(
                trans('approves.finish_checking')
            );
        }

        return view('admin.approves.index', compact(
            'unapproved_waiting', 'unapproved_checking', 'my_approves'
        ));
    }

    /**
     * @param Recipe $recipe
     */
    public function show(Recipe $recipe)
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        if (!optional($recipe->approver)->id) {
            $recipe->update([LANG() . '_approver_id' => user()->id]);
            $approver_id = user()->id;
        } else {
            $approver_id = $recipe->approver->id;
        }

        return view('admin.approves.show', compact('recipe', 'approver_id'));
    }

    /**
     * @param Recipe $recipe
     */
    public function approve(Recipe $recipe)
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")
                ->header('x-recipe-cant-be-approved', 0)
                ->withError($error_message);
        }

        event(new \App\Events\RecipeGotApproved($recipe));
        cache()->forget('unapproved_notif');

        return redirect("/recipes/$recipe->id")
            ->header('x-recipe-approved', 1)
            ->withSuccess(trans('recipes.recipe_published'));
    }

    /**
     * @param Recipe $recipe
     * @param DisapproveRequest $request
     */
    public function disapprove(Recipe $recipe, DisapproveRequest $request)
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")
                ->header('x-recipe-cant-be-approved', 0)
                ->withError($error_message);
        }

        event(new \App\Events\RecipeGotCanceled($recipe, $request->message));
        cache()->forget('unapproved_notif');

        return redirect('/recipes')
            ->header('x-recipe-disapproved', 1)
            ->withSuccess(trans('recipes.you_gave_recipe_back_on_editing'));
    }

    /**
     * @param $recipe
     */
    public function returnErrorIfApprovedOrNotReady(Recipe $recipe)
    {
        if ($recipe->isDone()) {
            return trans('approves.already_approved');
        }

        if (!$recipe->isReady() && !$recipe->isApproved()) {
            return trans('recipes.not_written');
        }
        return null;
    }
}
