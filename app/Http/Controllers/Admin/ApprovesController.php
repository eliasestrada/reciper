<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisapproveRequest;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApprovesController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Shows all recipes that need to be approved
     * by administration
     *
     * @return mixed
     */
    public function index()
    {
        $unapproved_waiting = Recipe::oldest()
            ->where(_('approver_id', true), 0)
            ->approved(0)
            ->ready(1)
            ->paginate(30)
            ->onEachSide(1);

        $unapproved_checking = Recipe::oldest()
            ->where(_('approver_id', true), '!=', 0)
            ->approved(0)
            ->ready(1)
            ->paginate(30)
            ->onEachSide(1);

        $my_approves = Recipe::oldest()
            ->where(_('approver_id', true), user()->id)
            ->done(1)
            ->paginate(30)
            ->onEachSide(1);

        // Check if admin is already has recipe that he didnt approve
        $already_checking = Recipe::where(_('approver_id', true), user()->id)->approved(0)->ready(1)->value('id');
        if ($already_checking) {
            return redirect("/admin/approves/$already_checking")
                ->withSuccess(trans('approves.finish_checking'));
        }

        return view('admin.approves.index', compact(
            'unapproved_waiting', 'unapproved_checking', 'my_approves'
        ));
    }

    /**
     * @param \App\Models\Recipe $recipe
     * @return mixed
     */
    public function show(Recipe $recipe)
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);
        $cookie = getCookie('r_font_size') ? getCookie('r_font_size') : '1.0';

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        if (!optional($recipe->approver)->id) {
            $recipe->update([_('approver_id', true) => user()->id]);
            $approver_id = user()->id;
        } else {
            $approver_id = $recipe->approver->id;
        }

        return view('admin.approves.show', compact('recipe', 'approver_id', 'cookie'));
    }

    /**
     * x-recipe-approved header is asserted by tests
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Recipe $recipe): RedirectResponse
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        event(new \App\Events\RecipeGotApproved($recipe));

        $recipe->update([_('approved') => 1]);
        cache()->forget('unapproved_notif');

        return redirect("/recipes/$recipe->slug")
            ->header('x-recipe-approved', 1)
            ->withSuccess(trans('recipes.recipe_published'));
    }

    /**
     * x-recipe-disapproved header is asserted by tests
     *
     * @param \App\Models\Recipe $recipe
     * @param \App\Http\Requests\DisapproveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disapprove(Recipe $recipe, DisapproveRequest $request): RedirectResponse
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        event(new \App\Events\RecipeGotCanceled($recipe, $request->message));

        $recipe->update([_('ready') => 0]);
        cache()->forget('unapproved_notif');

        return redirect('/recipes#new')
            ->header('x-recipe-disapproved', 1)
            ->withSuccess(trans('recipes.you_gave_recipe_back_on_editing'));
    }

    /**
     * Helper function
     *
     * @param \App\Models\Recipe $recipe
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
