<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisapproveRequest;
use App\Http\Responses\Controllers\Admin\Approves\IndexResponse;
use App\Http\Responses\Controllers\Admin\Approves\ShowResponse;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApproveController extends Controller
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
     * @return \App\Http\Responses\Controllers\Admin\Approves\IndexResponse
     */
    public function index(): IndexResponse
    {
        return new IndexResponse;
    }

    /**
     * Show single recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Admin\Approves\ShowResponse
     */
    public function show(Recipe $recipe): ShowResponse
    {
        return new ShowResponse($recipe);
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
